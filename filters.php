<?php
require_once __DIR__ . '/includes/db.php';
function build_filters_and_query(array $qs, string $type): array {
  $where = ["t.type = :type"]; $params = ['type'=>$type];
  if(!empty($qs['q'])){ $where[]="(t.title_fa LIKE :q OR t.title_en LIKE :q)"; $params['q']='%'.$qs['q'].'%'; }
  if(!empty($qs['genre'])){ $where[]="EXISTS(SELECT 1 FROM title_genres tg JOIN genres g ON g.id=tg.genre_id WHERE tg.title_id=t.id AND g.name=:genre)"; $params['genre']=$qs['genre']; }
  if(!empty($qs['country'])){ $where[]="EXISTS(SELECT 1 FROM title_countries tc JOIN countries c ON c.id=tc.country_id WHERE tc.title_id=t.id AND c.code=:cc)"; $params['cc']=$qs['country']; }
  if(isset($qs['mpaa']) && $qs['mpaa']!==''){ $where[]="t.mpaa = :mpaa"; $params['mpaa']=$qs['mpaa']; }
  if(isset($qs['dub'])){ $where[]="t.has_dub = :dub"; $params['dub']=(int)!!$qs['dub']; }
  if(isset($qs['sub'])){ $where[]="t.has_sub = :sub"; $params['sub']=(int)!!$qs['sub']; }
  if(isset($qs['online'])){ $where[]="t.online_play = :op"; $params['op']=(int)!!$qs['online']; }
  if(isset($qs['yfrom']) && is_numeric($qs['yfrom'])){ $where[]="t.year >= :yf"; $params['yf']=(int)$qs['yfrom']; }
  if(isset($qs['yto']) && is_numeric($qs['yto'])){ $where[]="t.year <= :yt"; $params['yt']=(int)$qs['yto']; }
  $sql = "SELECT t.* FROM titles t WHERE ".implode(' AND ', $where)." ORDER BY t.created_at DESC";
  return [$sql,$params];
}
