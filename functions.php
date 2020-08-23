
<?php
function h($n1,$n2=ENT_QUOTES){
    echo htmlspecialchars($n1,$n2);
}

function check($m1,$m2,$m3,$m4,$m5,$mysqli){
    
    if ($mysqli->connect_error){
        error_log($mysqli->connect_error);
        exit;
    }
    $cm="";
    $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
    $reg_str2='/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i';

    if(empty($m1)){
        $cm.='名前を入力してください。';
    } if(empty($m2)){
        $cm.='メールアドレスを入力してください。';
    } if(!empty($m2)){
        if (preg_match($reg_str,$m2)){
        $sql="SELECT * FROM users WHERE email='$m2'";
        $result=$mysqli->query($sql);
        if($result->num_rows > 0){
            $cm.='ご入力のメールアドレスはすでに登録されています。';
        } 
    } else {
        $cm.="メールアドレスを正しい型で入力してください。";
    }

    } if(empty($m3)){
        $cm.='パスワードを入力してください。';
    } if(!empty($m3)){
        if (!preg_match($reg_str2,$m3)){
            $cm.='パスワードは半角英数字８文字以上で設定してください。';
        }
    }if(empty($m4)){
        $cm.='郵便番号を入力してください。';
    } if(empty($m5)){
        $cm.='住所を入力してください。';
    } 

    $mysqli->close;
    
    return $cm;
} 

function p_ck($p1,$p2,$p3){
    $cp="";
    if(empty($p1)){
        $cp.='タイトルを記入してください。';
    } if(empty($p2)){
        $cp.='説明文を記入してください。';
    } if(empty($p3)){
        $cp.='YouTubeのURLを記入してください。';
    }

    return $cp;
}

function cm_ck($c){
    if(empty($c)){
        $cmck.='コメントが書かれていません。';
    }

    return $cmck;
}

function getRakutenResult($keyword,$min_price){
    $baseurl='https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222';
    $params = array();
    $params['applicationId'] ='1006938509987670476';
    $params['keyword'] = urlencode_rfc3986($keyword);
    $params['sort'] = urlencode_rfc3986('+itemPrice');
    $params['minPrice'] = $min_price;

    $canonical_string='';

    foreach($params as $k => $v) {
        $canonical_string .= '&' . $k . '=' . $v;
    }

    $canonical_string = substr($canonical_string, 1);
    $url = $baseurl . '?' . $canonical_string;
    $rakuten_json=json_decode(@file_get_contents($url, true));
    
    $items = array();
    foreach($rakuten_json->Items as $item) {
        $items[] = array(
                        'name' => (string)$item->Item->itemName,
                        'url' => (string)$item->Item->itemUrl,
                        'img' => isset($item->Item->mediumImageUrls[0]->imageUrl) ? (string)$item->Item->mediumImageUrls[0]->imageUrl : '',
                        'price' => (string)$item->Item->itemPrice,
                        'shop' => (string)$item->Item->shopName,
                        );
    }
    return $items;
}

function urlencode_rfc3986($str) {
    return str_replace('%7E', '~', rawurlencode($str));
}


?>