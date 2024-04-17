<?php

// 要查询的域名
$domain = 'alist.xf110.v6.rocks';

// 构建查询URL
$url = 'https://dns.google/resolve?name=' . $domain . '&type=TXT';

// 发起HTTP请求
$response = file_get_contents($url);

// 检查是否成功获取响应
if ($response === false) {
    echo '无法获取响应';
    exit;
}

// 解析JSON响应
$data = json_decode($response, true);

// 检查是否成功解析JSON
if ($data === null || !isset($data['Answer'])) {
    echo '无法解析响应';
    exit;
}

// 提取TXT记录
$txtRecords = array();
foreach ($data['Answer'] as $record) {
    if ($record['type'] === 16) { // TXT记录的type为16
        $txtRecords[] = $record['data'];
    }
}

// 打印TXT记录
if (empty($txtRecords)) {
    echo '未找到TXT记录';
} else {
    echo 'TXT记录：' . PHP_EOL;
    foreach ($txtRecords as $txtRecord) {
        echo $txtRecord . PHP_EOL;
    }
}

