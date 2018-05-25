<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 根据PHP各种类型变量生成唯一标识号
 * @param mixed $mix 变量
 * @return string
 */
// function to_guid_string($mix) {
//     if (is_object($mix)) {
//         return spl_object_hash($mix);
//     } elseif (is_resource($mix)) {
//         $mix = get_resource_type($mix) . strval($mix);
//     } else {
//         $mix = serialize($mix);
//     }
//     return md5($mix);
// }