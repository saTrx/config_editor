<?php

// ----------------------------------------------------------------
// creators and editors : Satrx - afshin-nova
error_reporting("1");
$proxy_list = null;
$costume_list = false;
// validator of arguments ...
if ($argc < 2) {print "\nError :: \n\tAarguments Not Found ! ...  \n";exit();}
// validator of arguments should be set only one proxy method ...
if (in_array("-url", $argv) && in_array("-file", $argv)) {
    echo "\nError :: \n\tyou can't use url with file Option ! ... \n";exit();
} elseif (in_array("-url", $argv)) {
    $key_num = array_search("-url", $argv);
    if (isset($argv[++$key_num])) {
        $proxy_list = file_get_contents($argv[$key_num]);
        $costume_list = true;
        unset($key_num);
    } else {
        echo "\Error :: \n\tUrl Value isn't Set ... \n";exit();
    }
} elseif (in_array("-file", $argv)) {
    $key_num = array_search("-file", $argv);
    if (isset($argv[++$key_num])) {
        $proxy_list = file_get_contents($argv[$key_num]);
        $costume_list = true;
    } else {
        echo "\nError :: \n\tfile aderess value Not found ! ... \n";exit();
    }
    unset($key_num);
} else {
    $proxy_list = file_get_contents("http://bot.sudoer.net/best.cf.iran");
    if (!$proxy_list) {echo "Error :: your connection is failed ... \ncheck the connection/:";}
}
// validator of type of proxy ...
if (in_array("-vmess", $argv)) {
    $key_num = array_search("-vmess", $argv);
    if (isset($argv[++$key_num])) {
        echo vmess_edit($argv[$key_num], $proxy_list, $costume_list);
        unset($key_num);
    } else {
        echo "\nError :: \n\tvmess value Not found ! ... \n";exit();
    }
} elseif (in_array("-vless", $argv)) {
    $key_num = array_search("-vless", $argv);
    if (isset($argv[++$key_num])) {
        echo vless_edit($argv[$key_num], $proxy_list, $costume_list);
        unset($key_num);
    } else {
        echo "\nError :: \n\tvless value Not Found ! ... \n";exit();
    }
} else {
    echo "\nError :: \n\tyour input arguments not valid ! ...\n\tcheck the input ...  \n";exit();
}

function vmess_edit($vmess, $proxy_list, bool $costume_list = false)
{
    var_dump($costume_list);
    $str = '';

    if ($costume_list == false) {
        preg_match_all("@^(.{3}) ([1234567890.]+)@mi", $proxy_list, $ip);
        if (preg_match_all("/vmess:\/\/([\w#^-_. =\/+]*)/mu", $vmess, $proxy)) {
            $str = "";
            foreach ($proxy[1] as $px) {
                $c = 0;
                $count = 0;
                foreach ($ip[2] as $i) {
                    $prx = base64_decode($px);
                    $json = json_decode($prx, 1);
                    $json["ps"] = "vmess-$ " . $ip[1][$c];
                    $json["add"] = $i;
                    $str .= "vmess://" . base64_encode(json_encode($json)) . "\n";
                    $c++;
                    unset($json);
                }
                $count++;
            }
            echo $str;
        } else {
            echo "Error :: Invalid configuration string";
        }
    } else {
        preg_match_all("@^.+\n@mi", $proxy_list, $ip);
        if (preg_match_all("/vmess:\/\/([\w#^-_. =\/+]*)/mu", $vmess, $proxy)) {
            $str = "";

            foreach ($proxy[1] as $px) {
                $c = 0;
                $count = 0;
                foreach ($ip[0] as $i) {
                    $prx = base64_decode($px);
                    $json = json_decode($prx, 1);
                    $json["ps"] = "vmess-$ " . $ip[0][$c];
                    $json["add"] = $i;
                    $str .= "vmess://" . base64_encode(json_encode($json)) . "\n";
                    $c++;
                    unset($json);
                }
                $count++;
            }
            echo $str;
        } else {
            echo "Error :: Invalid configuration string";
        }
    }

}

function vless_edit($vless, $proxy_list, $costume_list = false)
{
    if ($costume_list == false) {
        preg_match_all("@^(.{3}) ([1234567890.]+)@mi", $proxy_list, $ip);
        if (preg_match_all("/(^vless:\/\/.+)@(.+)\:(.+#)/mu", $vless, $proxy)) {
            $str = "";
            $c = 0;
                foreach ($ip[1] as $k => $v) {
                    $str .= $proxy[1][0] . "@" . $ip[2][array_search($v, $ip[1])] . ":" . $proxy[3][0].$v."\n";
                    $c++;
                
            }
            echo $str;
        } else {
            echo "Error :: Invalid configuration string";
        }
    } else {
        preg_match_all("@^.+\n@mi", $proxy_list, $ip);
        if (preg_match_all("/(^vless:\/\/.+)@(.+)\:(.+#)/mu", $vless, $proxy)) {
            $str = "";
            $co = 0;
                foreach ($ip[0] as $v) {
                $str .= $proxy[1][0] . "@" . $v . ":" . $proxy[3][0].$co."\n";
                $co++;
            }
            echo $str;
        } else {
            echo "Error :: Invalid configuration string";
        }
    
    }

}
