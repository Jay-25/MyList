<?php

namespace app\models;

/**
 *
 * @author Administrator
 *         @IP地址处理类
 */
class IP {
	/**
	 *
	 * @param $ip IP        	
	 * @return 转换后的Long值
	 */
	static public function ip2long($ip) {
		$ip_arr = explode ( '.', $ip );
		$iplong = (16777216 * intval ( $ip_arr [0] )) + (65536 * intval ( $ip_arr [1] )) + (256 * intval ( $ip_arr [2] )) + intval ( $ip_arr [3] );
		return $iplong;
	}
	/**
	 *
	 * @param $long long值        	
	 * @return IP地址
	 */
	static public function long2ip($long) {
		$ip1 = floor ( $long / 16777216 );
		$ip2 = floor ( ($long - $ip1 * 16777216) / 65536 );
		$ip3 = floor ( ($long - $ip1 * 16777216 - $ip2 * 65536) / 256 );
		$ip4 = $long - $ip1 * 16777216 - $ip2 * 65536 - $ip3 * 256;
		return $ip1 . "." . $ip2 . "." . $ip3 . "." . $ip4;
	}
	/**
	 *
	 * @return 获取域名
	 * @param $level 域名级数
	 *        	1：顶级域名 2：二级域名
	 *        	
	 */
	static public function getDomainName($url = null, $level = 1) {
		if (empty ( $url ))
			return '';
		preg_match ( "#http://(localhost)/#i", $url, $match );
		if (! empty ( $match [1] ) && strtolower ( $match [1] ) == 'localhost')
			return 'localhost';
		
		$domain = 'com|edu|cn|net|org|gov|info|la|cc|co|tv|travel|coop|biz|pro|or|museum|mobi';
		$country = 'at|ad|ae|af|ai|al|am|ao|aq|ar|as|au|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bw|bz|ca|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|fi|fj|fk|fm|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gp|gq|gr|gt|gu|gw|gy|hk|hn|hr|ht|hu|id|ie|il|in|iq|ir|is|it|jm|jo|jp|ke|kh|km|kr|kp|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|ml|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pr|pt|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|td|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tw|tz|ua|ug|uk|us|uy|uz|va|ve|vg|vi|vn|wf|ws|ye|yu|za|zm|zr|zw';
		/*
		 * AT .at 奥地利 AD .ad 安道尔 AE .ae 阿联酋 AF .af 阿富汗 AI .ai 安奎拉 AL .al 阿尔巴尼亚 AM .am 亚美尼亚 AO .ao 安哥拉 AQ .aq 南极洲 AR .ar 阿根廷 AS .as 美属萨摩亚群岛 AU .au 澳大利亚 AZ .az 阿塞拜疆 BA .ba 波斯尼亚和黑塞哥维那 BB .bb 巴巴多斯 BD .bd 孟加拉 BE .be 比利时 BF .bf 布基那法索 BG .bg 保加利亚 BH .bh 巴林 BI .bi 布隆迪 BJ .bj 贝宁 BM .bm 百慕大 BN .bn 文莱 BO .bo 玻利维亚 BR .br 巴西 BS .bs 巴哈马 BT .bt 不丹 BW .bw 博茨瓦纳 BZ .bz 伯利兹 CA .ca 加拿大 CF .cf 中非共和国 CG .cg 刚果 CH .ch 瑞士 CI .ci 象牙海岸 CK .ck 库克群岛 CL .cl 智利 CM .cm 喀麦隆 CN .cn 中国 CO .co 哥伦比亚 CR .cr 哥斯达黎加 CS .cs 捷克斯洛伐克（前） CU .cu 古巴 CV .cv 佛得角群岛 CY .cy 塞浦路斯 CZ .cz 捷克共和国 DE .de 德国 DJ .dj 吉布提 DK .dk 丹麦 DM .dm 多米尼加 DO .do 多米尼加共和国 DZ .dz 阿尔及利亚 EC .ec 厄瓜多尔 EE .ee 爱沙尼亚 EG .eg 埃及 EH .eh 西撒哈拉 ER .er 厄立特利亚 ES .es 西班牙 ET .et 埃塞俄比亚 FI .fi 芬兰 FJ .fj 斐济 FK .fk 马尔维那斯群岛 FM .fm 密克罗尼西亚 FR .fr 法国 GA .ga 加蓬 GB .gb 英国 GD .gd 格林纳达 GE .ge 乔治亚 GF .gf 法属圭亚那 GH .gh 加纳 GI .gi 直布罗陀 GL .gl 格陵兰（岛） GM .gm 赞比亚 GN .gn 几内亚 GP .gp 瓜德罗普 GQ .gq 赤道几内亚 GR .gr 希腊 GT .gt 危地马拉 GU .gu 关岛 GW .gw 几内亚比绍 GY .gy 圭亚那 HK .hk 香港 HN .hn 洪都拉斯 HR .hr 克罗地亚 HT .ht 海地 HU .hu 匈牙利 ID .id 印度尼西亚 IE .ie 爱尔兰 IL .il 以色列 IN .in 印度 IQ .iq 伊拉克 IR .ir 伊朗 IS .is 冰岛 IT .it 意大利 JM .jm 牙买加 JO .jo 约旦 JP .jp 日本 KE .ke 肯尼亚 KH .kh 柬埔寨 KM .km 科摩罗群岛 KR .kr 韩国 KP .kp 朝鲜 KW .kw 科威特 KY .ky 开曼群岛 KZ .kz 哈萨克斯坦 LA .la 老挝 LB .lb 黎巴嫩 LC .lc 圣路西亚 LI .li 列支敦士登 LK .lk 斯里兰卡 LR .lr 利比里亚 LS .ls 莱索托 LT .lt 立陶宛 LU .lu 卢森堡 LV .lv 拉托维亚 LY .ly 利比亚 MA .ma 摩洛哥 MC .mc 摩纳哥 MD .md 摩尔多瓦 ME .me 黑山 MG .mg 马达加斯加 MH .mh 马绍尔群岛 ML .ml 马里 MN .mn 蒙古 MO .mo 澳门 MP .mp 南马利亚那群岛 MQ .mq 马提尼克岛 MR .mr 毛里塔尼亚 MS .ms 蒙特塞拉特克岛 MT .mt 马耳他 MU .mu 毛里求斯 MV .mv 马尔代夫 MW .mw 马拉维 MX .mx 墨西哥 MY .my 马来西亚 MZ .mz 莫桑比克 NA .na 纳米比亚 NC .nc 新喀里多尼亚岛 NE .ne 尼日尔 NG .ng 尼日利亚 NI .ni 尼加拉瓜 NL .nl 荷兰 NO .no 挪威 NP .np 尼泊尔 NR .nr 瑙鲁 NU .nu 纽埃岛 NZ .nz 新西兰 OM .om 阿曼 PA .pa 巴拿马 PE .pe 秘鲁 PF .pf 法属玻利尼西亚 PG .pg 巴布亚新几内亚 PH .ph 菲律宾 PK .pk 巴基斯坦 PL .pl 波兰 PR .pr 波多黎哥 PT .pt 葡萄牙 PY .py 巴拉圭 QA .qa 卡塔尔 RE .re 留尼汪岛 RO .ro 罗马尼亚 RS .rs 塞尔维亚 RU .ru 俄罗斯 RW .rw 卢旺达 SA .sa 沙特阿拉伯 Sb .sb 所罗门群岛 SC .sc 塞舌尔 SD .sd 苏丹 SE .se 瑞典 SG .sg 新加坡 SH .sh 圣赫勒拿岛 SI .si 斯洛文尼亚 SJ .sj 斯瓦巴德群岛 SK .sk 斯洛伐克 SL .sl 塞拉利昂 SM .sm 圣马力诺 SN .sn 塞内加尔 SO .so 索马里 SR .sr 苏里南 ST .st 圣多美岛和普林西比岛 SU .su 苏联（前） SV .sv 萨尔瓦多 SY .sy 叙利亚 SZ .sz 斯威士兰 TD .td 乍得 TG .tg 多哥 TH .th 泰国 TJ .tj 塔吉克斯坦 TK .tk 托克劳群岛 TM .tm 土库曼斯坦 TN .tn 突尼斯 TO .to 汤加 TP .tp 东帝汶岛 TR .tr 土耳其 TT .tt 特立尼达和多巴哥 TW .tw 台湾 TZ .tz 坦桑尼亚 UA .ua 乌克兰 UG .ug 乌干达 UK .uk 英国 US .us 美国 UY .uy 乌拉圭 UZ .uz 乌兹别克斯坦 VA .va 梵蒂冈 VE .ve 委内瑞拉 VG .vg 维京岛（英） VI .vi 维京岛（美） VN .vn 越南 WF .wf 瓦利斯群岛 WS .ws 萨摩亚群岛 YE .ye 也门 YU .yu 南斯拉夫 ZA .za 南非 ZM .zm 赞比亚 ZR .zr 扎伊尔 ZW .zw 津巴布韦
		 */
		while ( $level > 0 ) {
			$preg_str .= '[\w-]+\.';
			$level --;
		}
		$preg_str = '#' . $preg_str . "(" . $domain . ")(\.(" . $country . "))*#i";
		preg_match ( $preg_str, $url, $match );
		return $match [0];
	}
	/**
	 *
	 * @return 获取IP
	 */
	static public function getRealIp() {
		$ip = false;
		if (! empty ( $_SERVER ["HTTP_CLIENT_IP"] )) {
			$ip = $_SERVER ["HTTP_CLIENT_IP"];
		}
		if (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$ips = explode ( ", ", $_SERVER ['HTTP_X_FORWARDED_FOR'] );
			if ($ip) {
				array_unshift ( $ips, $ip );
				$ip = FALSE;
			}
			for($i = 0; $i < count ( $ips ); $i ++) {
				if (! eregi ( "^(10|172\.16|192\.168)\.", $ips [$i] )) {
					$ip = $ips [$i];
					break;
				}
			}
		}
		return '115.28.76.20';
		return ($ip ? $ip : $_SERVER ['REMOTE_ADDR']);
	}
	
	static public function getServerIp() {
		return gethostbynamel ( $_SERVER ['NAME'] );
	}
	
	static public function getPosition($ip=null) {
		if(empty($ip)) $ip = static::getRealIp();
		
		$output = CUserCache::get("CurrentSessionPosition");
		if(is_array($output)) return $output;
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, "http://api.map.baidu.com/location/ip?ak=" . \Yii::$app->params['Map-Key'] . "&ip=" . $ip . "&coor=bd09ll" );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		$output = curl_exec ( $ch );
		curl_close ( $ch );

		if(!$output) return null;
		
		$output = json_decode($output);
		CUserCache::set("CurrentSessionPosition", $output);
		/*
		   content: stdClass{
				address: 北京市
				address_detail: stdClass{	
					city: 北京市	
					city_code: 131	
					district: 
					province: 北京市	
					street: 
					street_number: 
					}	
				point: stdClass{	
					x: 116.40387397	
					y: 39.91488908	
					}
			}
		 */
		return $output->content;
	}
	
	/**
	 *
	 * @param $p1 位置1（经纬度）        	
	 * @param $p2 位置2（经纬度）        	
	 * @return 距离
	 */
	static public function calDistance($p1 = array(0,0), $p2 = array(0,0)) 	// array(latitude,longitude)
	{
		$EARTH_RADIUS = 6378.137; // 地球半径（公里）
		$radLat1 = $p1 [0] * 3.1415926535898 / 180.0;
		$radLat2 = $p2 [0] * 3.1415926535898 / 180.0;
		$a = $radLat1 - $radLat2;
		$b = ($p1 [1] - $p2 [1]) * 3.1415926535898 / 180.0;
		
		$s = 2 * $EARTH_RADIUS * asin ( sqrt ( pow ( sin ( $a / 2 ), 2 ) + cos ( $radLat1 ) * cos ( $radLat2 ) * pow ( sin ( $b / 2 ), 2 ) ) );
		$s = round ( $s * 10000 ) / 10000;
		return $s;
	}
}
