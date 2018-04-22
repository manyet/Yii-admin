/*
Navicat MySQL Data Transfer

Source Server         : 172.18.0.13(develop)
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : wechat

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-11-16 09:54:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for common_cache
-- ----------------------------
DROP TABLE IF EXISTS `common_cache`;
CREATE TABLE `common_cache` (
  `id` char(128) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_cache
-- ----------------------------
INSERT INTO `common_cache` VALUES ('963454f612a8b5fb4a63ba1e97f028a1', '0', 0x613A323A7B693A303B613A323A7B693A303B613A333A7B693A303B4F3A31353A227969695C7765625C55726C52756C65223A31343A7B733A343A226E616D65223B733A32353A223C636F6E74726F6C6C65723A5C772B3E2F3C69643A5C642B3E223B733A373A227061747465726E223B733A34323A22235E283F503C6134636632363639613E5C772B292F283F503C6162663339363735303E5C642B29242375223B733A343A22686F7374223B4E3B733A353A22726F757465223B733A31373A223C636F6E74726F6C6C65723E2F76696577223B733A383A2264656661756C7473223B613A303A7B7D733A363A22737566666978223B4E3B733A343A2276657262223B4E3B733A343A226D6F6465223B4E3B733A31323A22656E636F6465506172616D73223B623A313B733A31353A22002A00706C616365686F6C64657273223B613A323A7B733A393A22613463663236363961223B733A31303A22636F6E74726F6C6C6572223B733A393A22616266333936373530223B733A323A226964223B7D733A32363A22007969695C7765625C55726C52756C65005F74656D706C617465223B733A31393A222F3C636F6E74726F6C6C65723E2F3C69643E2F223B733A32373A22007969695C7765625C55726C52756C65005F726F75746552756C65223B733A32383A22235E283F503C6134636632363639613E5C772B292F76696577242375223B733A32383A22007969695C7765625C55726C52756C65005F706172616D52756C6573223B613A313A7B733A323A226964223B733A383A22235E5C642B242375223B7D733A32393A22007969695C7765625C55726C52756C65005F726F757465506172616D73223B613A313A7B733A31303A22636F6E74726F6C6C6572223B733A31323A223C636F6E74726F6C6C65723E223B7D7D693A313B4F3A31353A227969695C7765625C55726C52756C65223A31343A7B733A343A226E616D65223B733A33383A223C636F6E74726F6C6C65723A5C772B3E2F3C616374696F6E3A5C772B3E2F3C69643A5C642B3E223B733A373A227061747465726E223B733A36313A22235E283F503C6134636632363639613E5C772B292F283F503C6134376363386339323E5C772B292F283F503C6162663339363735303E5C642B29242375223B733A343A22686F7374223B4E3B733A353A22726F757465223B733A32313A223C636F6E74726F6C6C65723E2F3C616374696F6E3E223B733A383A2264656661756C7473223B613A303A7B7D733A363A22737566666978223B4E3B733A343A2276657262223B4E3B733A343A226D6F6465223B4E3B733A31323A22656E636F6465506172616D73223B623A313B733A31353A22002A00706C616365686F6C64657273223B613A333A7B733A393A22613463663236363961223B733A31303A22636F6E74726F6C6C6572223B733A393A22613437636338633932223B733A363A22616374696F6E223B733A393A22616266333936373530223B733A323A226964223B7D733A32363A22007969695C7765625C55726C52756C65005F74656D706C617465223B733A32383A222F3C636F6E74726F6C6C65723E2F3C616374696F6E3E2F3C69643E2F223B733A32373A22007969695C7765625C55726C52756C65005F726F75746552756C65223B733A34323A22235E283F503C6134636632363639613E5C772B292F283F503C6134376363386339323E5C772B29242375223B733A32383A22007969695C7765625C55726C52756C65005F706172616D52756C6573223B613A313A7B733A323A226964223B733A383A22235E5C642B242375223B7D733A32393A22007969695C7765625C55726C52756C65005F726F757465506172616D73223B613A323A7B733A31303A22636F6E74726F6C6C6572223B733A31323A223C636F6E74726F6C6C65723E223B733A363A22616374696F6E223B733A383A223C616374696F6E3E223B7D7D693A323B4F3A31353A227969695C7765625C55726C52756C65223A31343A7B733A343A226E616D65223B733A32393A223C636F6E74726F6C6C65723A5C772B3E2F3C616374696F6E3A5C772B3E223B733A373A227061747465726E223B733A34323A22235E283F503C6134636632363639613E5C772B292F283F503C6134376363386339323E5C772B29242375223B733A343A22686F7374223B4E3B733A353A22726F757465223B733A32313A223C636F6E74726F6C6C65723E2F3C616374696F6E3E223B733A383A2264656661756C7473223B613A303A7B7D733A363A22737566666978223B4E3B733A343A2276657262223B4E3B733A343A226D6F6465223B4E3B733A31323A22656E636F6465506172616D73223B623A313B733A31353A22002A00706C616365686F6C64657273223B613A323A7B733A393A22613463663236363961223B733A31303A22636F6E74726F6C6C6572223B733A393A22613437636338633932223B733A363A22616374696F6E223B7D733A32363A22007969695C7765625C55726C52756C65005F74656D706C617465223B733A32333A222F3C636F6E74726F6C6C65723E2F3C616374696F6E3E2F223B733A32373A22007969695C7765625C55726C52756C65005F726F75746552756C65223B733A34323A22235E283F503C6134636632363639613E5C772B292F283F503C6134376363386339323E5C772B29242375223B733A32383A22007969695C7765625C55726C52756C65005F706172616D52756C6573223B613A303A7B7D733A32393A22007969695C7765625C55726C52756C65005F726F757465506172616D73223B613A323A7B733A31303A22636F6E74726F6C6C6572223B733A31323A223C636F6E74726F6C6C65723E223B733A363A22616374696F6E223B733A383A223C616374696F6E3E223B7D7D7D693A313B733A33323A223733623731626637346231303364306163383763633730666334303864643235223B7D693A313B4E3B7D);
INSERT INTO `common_cache` VALUES ('accessToken', '1510225214', 0x613A323A7B693A303B693A3132333B693A313B4E3B7D);
INSERT INTO `common_cache` VALUES ('config', '0', 0x613A323A7B693A303B613A31393A7B733A31343A225745425F534954455F5449544C45223B733A31383A22E5BEAEE4BFA1E7AEA1E79086E5B9B3E58FB0223B733A31353A22434F4D504C41494E545F50484F4E45223B733A31313A223630313738333230363233223B733A31363A22435553544F4D5F54454C4550484F4E45223B733A31313A223630313738333230363233223B733A31343A2244454C49564552595F52414E4745223B733A323A223130223B733A31383A225745425F534954455F434F50595249474854223B733A333A2242424D223B733A32333A225745425F534954455F434F505952494748545F4C494E4B223B733A32333A22687474703A2F2F7777772E62626D6D6172696E2E636F6D223B733A32303A225745425F534954455F4445534352495054494F4E223B733A31383A22E5BEAEE4BFA1E7AEA1E79086E5B9B3E58FB0223B733A31353A225745425F41444D494E5F5449544C45223B733A31383A22E5BEAEE4BFA1E7AEA1E79086E5B9B3E58FB0223B733A31313A2246554C4C5F53435245454E223B733A313A2231223B733A31363A22434F4E4649475F545950455F4C495354223B613A333A7B693A303B733A313A2231223B693A313B733A313A2232223B693A323B733A313A2233223B7D733A31373A22434F4E4649475F47524F55505F4C495354223B733A313A2231223B733A31363A225745425F534954455F4B4559574F5244223B733A31383A22E5BEAEE4BFA1E7AEA1E79086E5B9B3E58FB0223B733A31323A225745425F534954455F494350223B733A363A22494350E5A487223B733A31313A22434F4C4F525F5354594C45223B733A31303A22626C75652D6C69676874223B733A393A224C4953545F524F5753223B733A323A223130223B733A31343A225745425F534954455F434C4F5345223B733A313A2231223B733A31303A224A535F56455253494F4E223B733A333A22312E30223B733A31313A224353535F56455253494F4E223B733A333A22312E30223B733A333A22475354223B733A313A2236223B7D693A313B4E3B7D);
INSERT INTO `common_cache` VALUES ('menu', '0', 0x613A323A7B693A303B613A343A7B693A303B613A373A7B733A323A226964223B733A313A2239223B733A393A22706172656E745F6964223B733A313A2230223B733A353A227469746C65223B733A31323A22E5BEAEE4BFA1E7AEA1E79086223B733A343A2269636F6E223B733A31323A2266612066612D776563686174223B733A333A2275726C223B733A313A2223223B733A363A22706172616D73223B733A303A22223B733A383A226368696C6472656E223B613A313A7B693A303B613A363A7B733A323A226964223B733A323A223130223B733A393A22706172656E745F6964223B733A313A2239223B733A353A227469746C65223B733A31353A22E585ACE4BC97E58FB7E7AEA1E79086223B733A343A2269636F6E223B733A31313A2266612066612D6368696C64223B733A333A2275726C223B733A31393A227765636861742D636F6E6669672F696E646578223B733A363A22706172616D73223B733A303A22223B7D7D7D693A313B613A373A7B733A323A226964223B733A323A223131223B733A393A22706172656E745F6964223B733A313A2230223B733A353A227469746C65223B733A31323A22E59BBEE69687E7AEA1E79086223B733A343A2269636F6E223B733A303A22223B733A333A2275726C223B733A313A2223223B733A363A22706172616D73223B733A303A22223B733A383A226368696C6472656E223B613A323A7B693A303B613A363A7B733A323A226964223B733A323A223132223B733A393A22706172656E745F6964223B733A323A223131223B733A353A227469746C65223B733A31323A22E69687E7ABA0E7AEA1E79086223B733A343A2269636F6E223B733A303A22223B733A333A2275726C223B733A32303A227765636861742D61727469636C652F696E646578223B733A363A22706172616D73223B733A303A22223B7D693A313B613A363A7B733A323A226964223B733A313A2238223B733A393A22706172656E745F6964223B733A323A223131223B733A353A227469746C65223B733A31353A22E5A49AE59BBEE69687E7AEA1E79086223B733A343A2269636F6E223B733A31343A2266612066612D6C6973742D616C74223B733A333A2275726C223B733A32313A227765636861742D61727469636C65732F696E646578223B733A363A22706172616D73223B733A303A22223B7D7D7D693A323B613A373A7B733A323A226964223B733A313A2236223B733A393A22706172656E745F6964223B733A313A2230223B733A353A227469746C65223B733A31323A22E887AAE58AA8E59B9EE5A48D223B733A343A2269636F6E223B4E3B733A333A2275726C223B733A313A2223223B733A363A22706172616D73223B4E3B733A383A226368696C6472656E223B613A313A7B693A303B613A363A7B733A323A226964223B733A313A2237223B733A393A22706172656E745F6964223B733A313A2236223B733A353A227469746C65223B733A31323A22E585B3E6B3A8E59B9EE5A48D223B733A343A2269636F6E223B733A303A22223B733A333A2275726C223B733A32323A227765636861742D7265706C792F737562736372696265223B733A363A22706172616D73223B733A303A22223B7D7D7D693A333B613A373A7B733A323A226964223B733A313A2231223B733A393A22706172656E745F6964223B733A313A2230223B733A353A227469746C65223B733A31323A22E7B3BBE7BB9FE7AEA1E79086223B733A343A2269636F6E223B733A31303A2266612066612D636F6773223B733A333A2275726C223B733A313A2223223B733A363A22706172616D73223B733A303A22223B733A383A226368696C6472656E223B613A333A7B693A303B613A363A7B733A323A226964223B733A313A2232223B733A393A22706172656E745F6964223B733A313A2231223B733A353A227469746C65223B733A31323A22E7B3BBE7BB9FE794A8E688B7223B733A343A2269636F6E223B733A31313A2266612066612D67726F7570223B733A333A2275726C223B733A31303A22757365722F696E646578223B733A363A22706172616D73223B733A303A22223B7D693A313B613A363A7B733A323A226964223B733A313A2233223B733A393A22706172656E745F6964223B733A313A2231223B733A353A227469746C65223B733A31323A22E8A792E889B2E7AEA1E79086223B733A343A2269636F6E223B733A31323A2266612066612D64727570616C223B733A333A2275726C223B733A31303A22726F6C652F696E646578223B733A363A22706172616D73223B733A303A22223B7D693A323B613A363A7B733A323A226964223B733A313A2234223B733A393A22706172656E745F6964223B733A313A2231223B733A353A227469746C65223B733A31323A22E88F9CE58D95E7AEA1E79086223B733A343A2269636F6E223B733A31363A2266612066612D616C69676E2D6C656674223B733A333A2275726C223B733A31303A226D656E752F696E646578223B733A363A22706172616D73223B733A303A22223B7D7D7D7D693A313B4E3B7D);

-- ----------------------------
-- Table structure for common_session
-- ----------------------------
DROP TABLE IF EXISTS `common_session`;
CREATE TABLE `common_session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_session
-- ----------------------------
INSERT INTO `common_session` VALUES ('0fn9odh1ft0r6e2pi0iujdtf82', '1510656646', 0x5F5F666C6173687C613A303A7B7D5F5F636170746368612F6D61696E2F636170746368617C733A353A223131313737223B5F5F636170746368612F6D61696E2F63617074636861636F756E747C693A313B757365727C613A363A7B733A323A226964223B733A313A2231223B733A383A22757365726E616D65223B733A353A2261646D696E223B733A373A22726F6C655F6964223B733A313A2231223B733A383A227265616C6E616D65223B733A393A22E7AEA1E79086E59198223B733A363A22617661746172223B733A36353A222F6D6F726546756E2F6170706C69636174696F6E2F61646D696E2F7765622F6173736574732F75706C6F61642F626435343631666365386266656231332E6A7067223B733A31313A226372656174655F74696D65223B733A31303A2231343930353939323031223B7D);
INSERT INTO `common_session` VALUES ('5a451jftsv7tqmo4v0fam10qc6', '1510735806', 0x5F5F666C6173687C613A303A7B7D5F5F636170746368612F6D61696E2F636170746368617C733A353A223038323637223B5F5F636170746368612F6D61696E2F63617074636861636F756E747C693A313B757365727C613A363A7B733A323A226964223B733A313A2231223B733A383A22757365726E616D65223B733A353A2261646D696E223B733A373A22726F6C655F6964223B733A313A2231223B733A383A227265616C6E616D65223B733A393A22E7AEA1E79086E59198223B733A363A22617661746172223B733A36353A222F6D6F726546756E2F6170706C69636174696F6E2F61646D696E2F7765622F6173736574732F75706C6F61642F626435343631666365386266656231332E6A7067223B733A31313A226372656174655F74696D65223B733A31303A2231343930353939323031223B7D);
INSERT INTO `common_session` VALUES ('aet06b3t8psp5ag57akhtsits1', '1510730801', 0x5F5F666C6173687C613A303A7B7D5F5F636170746368612F6D61696E2F636170746368617C733A353A223936313639223B5F5F636170746368612F6D61696E2F63617074636861636F756E747C693A313B757365727C613A363A7B733A323A226964223B733A313A2231223B733A383A22757365726E616D65223B733A353A2261646D696E223B733A373A22726F6C655F6964223B733A313A2231223B733A383A227265616C6E616D65223B733A393A22E7AEA1E79086E59198223B733A363A22617661746172223B733A36353A222F6D6F726546756E2F6170706C69636174696F6E2F61646D696E2F7765622F6173736574732F75706C6F61642F626435343631666365386266656231332E6A7067223B733A31313A226372656174655F74696D65223B733A31303A2231343930353939323031223B7D);
INSERT INTO `common_session` VALUES ('s406h51sf07tlsuf46915m1m70', '1510657146', 0x5F5F666C6173687C613A303A7B7D5F5F636170746368612F6D61696E2F636170746368617C733A363A22363136313439223B5F5F636170746368612F6D61696E2F63617074636861636F756E747C693A313B757365727C613A363A7B733A323A226964223B733A313A2231223B733A383A22757365726E616D65223B733A353A2261646D696E223B733A373A22726F6C655F6964223B733A313A2231223B733A383A227265616C6E616D65223B733A393A22E7AEA1E79086E59198223B733A363A22617661746172223B733A36353A222F6D6F726546756E2F6170706C69636174696F6E2F61646D696E2F7765622F6173736574732F75706C6F61642F626435343631666365386266656231332E6A7067223B733A31313A226372656174655F74696D65223B733A31303A2231343930353939323031223B7D);
INSERT INTO `common_session` VALUES ('tdaj1vbgr4r3sn8k5sk279fqm5', '1510732539', 0x5F5F666C6173687C613A303A7B7D5F5F636170746368612F6D61696E2F636170746368617C733A353A223231333133223B5F5F636170746368612F6D61696E2F63617074636861636F756E747C693A313B757365727C613A363A7B733A323A226964223B733A313A2231223B733A383A22757365726E616D65223B733A353A2261646D696E223B733A373A22726F6C655F6964223B733A313A2231223B733A383A227265616C6E616D65223B733A393A22E7AEA1E79086E59198223B733A363A22617661746172223B733A36353A222F6D6F726546756E2F6170706C69636174696F6E2F61646D696E2F7765622F6173736574732F75706C6F61642F626435343631666365386266656231332E6A7067223B733A31313A226372656174655F74696D65223B733A31303A2231343930353939323031223B7D);

-- ----------------------------
-- Table structure for new_message_template
-- ----------------------------
DROP TABLE IF EXISTS `new_message_template`;
CREATE TABLE `new_message_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL DEFAULT '' COMMENT '模板调用key',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '模板标题',
  `mobile_content` varchar(255) NOT NULL DEFAULT '' COMMENT '短信内容',
  `message_content` varchar(500) NOT NULL DEFAULT '' COMMENT '消息内容',
  `is_send_mobile` tinyint(1) unsigned NOT NULL COMMENT '是否发送短信 0.不发送 1.发送',
  `is_send_message` tinyint(1) unsigned NOT NULL COMMENT '是否发送消息 0.不发送 1.发送',
  `params` varchar(255) NOT NULL DEFAULT '' COMMENT '模板支持参数，JSON格式',
  `description` varchar(255) DEFAULT NULL COMMENT '模板描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='消息模板表';

-- ----------------------------
-- Records of new_message_template
-- ----------------------------
INSERT INTO `new_message_template` VALUES ('1', 'ryder-register-success', '骑士注册成功', '【Morefun Rider】Dear  {{RyderName}},you have successfully become a Rider.Please keep your Rider ID and password.Rider ID:{{RyderID}},Initial Password:{{InitialPassword}}.Please change the initial password after first login.', '【Morefun Ryder】Dear {{RyderName}},you have successfully become a Ryder.Please keep your Ryder ID and password.Ryder ID:{{RyderID}},Initial Password:{{InitialPassword}}.Please change the initial password after first login.', '1', '0', '{\"RyderName\":\"骑士姓名\",\"RyderID\":\"骑士编号\",\"InitialPassword\":\"初始密码\"}', '外卖骑士注册成功（同时满足设置初始密码和解冻为正常状态时），初始密码下发');
INSERT INTO `new_message_template` VALUES ('2', 'ryder-password-success', '骑士修改/重置密码', '【Morefun Rider】Dear {{RyderName}},you have successfully changed your password. For enquiries, please contact Morefun Service Center.', '【Morefun Ryder】Dear {{RyderName}},you have successfully change your password.If you have any questions please contact with Morefun Service Center.', '1', '0', '{\"RyderName\":\"骑士姓名\"}', '外卖骑士修改密码/重置密码成功下发，目前仅Reset password页面触发');
INSERT INTO `new_message_template` VALUES ('3', 'store-password-success', '商家修改/重置密码', '【Morefun Merchant】Dear {{MerchantName}}, you have successfully changed your password. If you have any questions, please contact Morefun Service Center.', '【Morefun Merchant】Dear {{MerchantName}},you have successfully change your password.If you have any questions please contact with Morefun Service Center.', '1', '0', '{\"MerchantName\":\"商家姓名\"}', '外卖商家修改密码/重置密码成功下发，目前仅Reset password页面触发');
INSERT INTO `new_message_template` VALUES ('4', 'ryder-recharge', '骑士充值额度动态', '【Morefun Exchange】Dear {{RyderName}}, your have successfully reloaded {{MorepayCredit}}. Your current Morepay balance is RM{{MorepayBalance}}.', '【Morefun Exchange】Dear {{RyderName}}, your have successfully reloaded {{MorepayCredit}}. Your current Morepay balance is RM{{MorepayBalance}}.', '1', '1', '{\"RyderName\":\"骑士姓名\",\"MorepayCredit\":\"充值额度\",\"MorepayBalance\":\"马币余额\"}', '骑士充值页面操作充值成功后触发');
INSERT INTO `new_message_template` VALUES ('5', 'client-recharge', '客户充值余额动态', '【Morefun Exchange】Dear {{UserName}}, your have successfully reloaded {{MorepayCredit}}. Your current Morepay balance is RM{{MorepayBalance}}.', '【Morefun Exchange】Dear {{UserName}}, your have successfully reloaded {{MorepayCredit}}. Your current Morepay balance is RM{{MorepayBalance}}.', '1', '1', '{\"UserName\":\"用户姓名\",\"MorepayCredit\":\"充值额度\",\"MorepayBalance\":\"马币余额\"}', '骑士充值页面操作充值，金额成功入账客户端账户中后触发');
INSERT INTO `new_message_template` VALUES ('6', 'client-consume', '客户消费余额动态', '【Morefun】Dear {{UserName}}, you have spent a total of RM{{Consume}}. Your remaining Morepay balance is RM{{MorepayBalance}}.', '【Morefun】Dear {{UserName}}, you have spent a total of RM{{Consume}}. Your remaining Morepay balance is RM{{MorepayBalance}}.', '1', '1', '{\"UserName\":\"用户姓名\",\"Consume\":\"消费金额\",\"MorepayBalance\":\"马币余额\"}', '客户线上选择Morepay支付成功后触发');
INSERT INTO `new_message_template` VALUES ('7', 'merchant-freeze', '商家账户冻结', '【Morefun Merchant】Dear {{MerchantName}}, your account has been suspended. Please contact Morefun Service Center for assistance.', '【Morefun Merchant】Dear {{MerchantName}},your account access has been limited.If you have any questions please contact with Morefun Service Center.', '1', '0', '{\"MerchantName\":\"商家姓名\"}', '外卖商家账户冻结状态时触发');
INSERT INTO `new_message_template` VALUES ('8', 'knight-Freeze', '骑士账户冻结', '【Morefun Rider】Dear {{RyderName}}, your account has been suspended. Please contact Morefun Service Center for assistance.', '【Morefun Ryder】Dear {{RyderName}},your account access has been limited.If you have any questions please contact with Morefun Service Center.', '1', '0', '{\"RyderName\":\"骑士姓名\"}', '外卖骑士账户冻结状态时触发');
INSERT INTO `new_message_template` VALUES ('9', 'merchant-unfreeze', '商家账户解冻', '【Morefun Merchant】Dear {{MerchantName}}, your account will be activated shortly.', '【Morefun Merchant】Dear {{MerchantName}},your account is going back to normal.', '1', '0', '{\"MerchantName\":\"商家姓名\"}', '外卖商家账户解冻变为正常状态时触发');
INSERT INTO `new_message_template` VALUES ('10', 'knight-thaw', '骑士账户解冻', '【Morefun Ryder】Dear {{RyderName}}, your account will be activated shortly. ', '【Morefun Ryder】Dear {{RyderName}},your account is going back to normal.', '1', '0', '{\"RyderName\":\"骑士姓名\"}', '外卖骑士账户解冻变为正常状态时触发');
INSERT INTO `new_message_template` VALUES ('11', 'order-created', '下单成功', 'Your order number is {{OrderNumber}} and the order is completed,please waiting for merchant to receive the order.', 'You have successfully placed an order - OrderNo.:{{OrderNumber}}. Awaiting for merchant\'s confirmation.', '0', '1', '{\"OrderNumber\":\"订单编号\"}', '1、用户选择线下付款时，提交订单，成功生成待接单状态时触发；\r\n2、用户选择线上付款，在支付之后，成功生成待接单状态时触发。');
INSERT INTO `new_message_template` VALUES ('12', 'order-wait-for-recieve-store', '通知接单-商家', 'You just receive a new take-out order and the order number is {{OrderNumber}},please confirm.', 'You have received a new take-out order - OrderNo.:{{OrderNumber}}. Kindly confirm the order.', '0', '1', '{\"OrderNumber\":\"订单编号\"}', '用户下单成功后触发，通知商家前台+商家后台进行接单');
INSERT INTO `new_message_template` VALUES ('13', 'order-wait-for-recieve-company', '通知接单-总部', 'Merchant ID:{{MerchantID}},Merchant Name:{{MerchantName}},receive a new take-out order,please confirm.', 'Merchant ID:{{MerchantID}},Merchant Name:{{MerchantName}}, new order received. Please confirm.', '0', '1', '{\"OrderNumber\":\"订单编号\",\"MerchantID\":\"商家编号\"}', '用户下单成功后触发，通知总部协助接单');
INSERT INTO `new_message_template` VALUES ('14', 'taking-success', '接单成功', 'Your order number {{OrderNumber}} is received successfully by merchant,please waiting for the delivery of food.', 'Your item - OrderNo.:{{OrderNumber}} has been confirmed. Item delivery will commence shortly.', '0', '1', '{\"OrderNumber\":\"订单编号\"}', '商家接单成功后触发，通知用户结果');
INSERT INTO `new_message_template` VALUES ('15', 'taking-failed', '接单失败', '【Morefun】Dear {{UserName}}, your order - OrderNo:{{OrderNumber}} is unsucessful. Please contact Morefun Service Center for assistance.', '【Morefun】Dear {{UserName}}, your order - OrderNo:{{OrderNumber}} is unsucessful. Please contact Morefun Service Center for assistance.', '1', '1', '{\"OrderNumber\":\"订单编号\",\"UserName\":\"用户姓名\"}', '商家接单失败后触发，通知用户结果');
INSERT INTO `new_message_template` VALUES ('16', 'order-wait-for-delivery', '通知指派', 'Order Number:{{OrderNumber}},received successfully by merchant,please arrange ryder to delivery.', 'Order No.:{{OrderNumber}} has been received successfully by merchant. Please assign to rider for delivery.', '0', '1', '{\"OrderNumber\":\"订单编号\"}', '商家接单成功后触发，通知总部进行指派');
INSERT INTO `new_message_template` VALUES ('17', 'delivery-success', '指派成功', '【Morefun Merchant】OrderNo.:{{OrderNumber}}, rider is on the way to collect the item. Please be prepared on time.', '【Morefun Merchant】OrderNo.:{{OrderNumber}}, rider is on the way to collect the item. Please be prepared on time.', '1', '1', '{\"OrderNumber\":\"订单编号\"}', '总部指派成功后触发，通知商家准备出餐');
INSERT INTO `new_message_template` VALUES ('18', 'order-wait-for-delivering-knig', '通知配送-骑士', '【Morefun Rider】Order Number:{{OrderNumber}}, you have received a new task. Please confirm.', '【Morefun Rider】Order Number:{{OrderNumber}}, you have received a new task. Please confirm.', '1', '1', '{\"OrderNumber\":\"订单编号\"}', '总部指派成功后触发，通知骑士取货配送');
INSERT INTO `new_message_template` VALUES ('19', 'order-wait-for-delivering-client', '通知配送-用户', '【Morefun】Dear {{ConsigneeName}}, your item [OrderNo.:{{OrderNumber}}] is being distributed. For enquiries, please contact Morefun Service Center.', '【Morefun】Dear {{ConsigneeName}}, your item [OrderNo.:{{OrderNumber}}] is being distributed. For enquiries, please contact Morefun Service Center.', '1', '1', '{\"OrderNumber\":\"订单编号\",\"ConsigneeName\":\"收货人姓名\"}', '总部指派成功后触发，通知用户结果');
INSERT INTO `new_message_template` VALUES ('20', 'delivery-finish-merchant', '配送完成-商家', 'Order Number:{{OrderNumber}},delivery was successfully sent to the client.', 'Order Number:{{OrderNumber}}, delivery is successfully sent to client.', '0', '1', '{\"OrderNumber\":\"订单编号\"}', '骑士送餐完成后触发，通知商家结果');
INSERT INTO `new_message_template` VALUES ('21', 'delivery-finish-company', '配送完成-总部', 'Order Number:{{OrderNumber}},delivery was successfully sent to the client.', 'Order Number:{{OrderNumber}}, delivery is successfully sent to the client.', '0', '1', '{\"OrderNumber\":\"订单编号\"}', '骑士送餐完成后触发，通知总部结果');
INSERT INTO `new_message_template` VALUES ('22', 'admin-recieve-delivery', '后台接单-商家', '【Morefun Merchant】您有一个新的订单，请查看商户管理后台，订单号{{OrderNumber}}。You\'ve a new order. Please check your system immediately. Order No. {{OrderNumber}}.(http://www.morefun.my) ', '【Morefun Merchant】您有一个新的订单，请查看商户管理后台，订单号{{OrderNumber}}。You\'ve a new order. Please check your system immediately. Order No. {{OrderNumber}}.(http://www.morefun.my) ', '1', '1', '{\"OrderNumber\":\"订单编号\"}', '后台接单后触发，通知商家备餐');

-- ----------------------------
-- Table structure for new_notice
-- ----------------------------
DROP TABLE IF EXISTS `new_notice`;
CREATE TABLE `new_notice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` varchar(1000) DEFAULT NULL COMMENT '内容',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `type` tinytext COMMENT '发送对象(1：用户，2：商家，3：骑士)',
  `create_time` varchar(255) DEFAULT NULL COMMENT '创建时间',
  `user_id` int(10) DEFAULT NULL COMMENT '关联new_store_system_user表id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息';

-- ----------------------------
-- Records of new_notice
-- ----------------------------

-- ----------------------------
-- Table structure for new_notice_company
-- ----------------------------
DROP TABLE IF EXISTS `new_notice_company`;
CREATE TABLE `new_notice_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` varchar(1000) NOT NULL COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL COMMENT '发送对象(1：用户，2：骑士，3：商家)',
  `individual_id` varchar(50) DEFAULT NULL COMMENT '个体id',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息';

-- ----------------------------
-- Records of new_notice_company
-- ----------------------------

-- ----------------------------
-- Table structure for new_notice_individual
-- ----------------------------
DROP TABLE IF EXISTS `new_notice_individual`;
CREATE TABLE `new_notice_individual` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` varchar(1000) NOT NULL COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL COMMENT '发送对象(1：用户，2：骑士，3：商家)',
  `individual_id` varchar(50) NOT NULL COMMENT '个体id',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `read` tinyint(3) unsigned DEFAULT '0' COMMENT '是否已读 0：否，1：是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息';

-- ----------------------------
-- Records of new_notice_individual
-- ----------------------------

-- ----------------------------
-- Table structure for new_sms_async
-- ----------------------------
DROP TABLE IF EXISTS `new_sms_async`;
CREATE TABLE `new_sms_async` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipient` varchar(255) NOT NULL COMMENT 'url',
  `content` text NOT NULL COMMENT '图标',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0：待发送，1：发送成功',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `times` int(10) unsigned DEFAULT '0' COMMENT '发送次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='异步发送短信';

-- ----------------------------
-- Records of new_sms_async
-- ----------------------------

-- ----------------------------
-- Table structure for new_sms_record
-- ----------------------------
DROP TABLE IF EXISTS `new_sms_record`;
CREATE TABLE `new_sms_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipient` varchar(255) NOT NULL COMMENT 'url',
  `content` text NOT NULL COMMENT '图标',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0：失败，1：成功',
  `result` varchar(255) NOT NULL COMMENT '菜单名',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信发送记录';

-- ----------------------------
-- Records of new_sms_record
-- ----------------------------

-- ----------------------------
-- Table structure for new_system_config
-- ----------------------------
DROP TABLE IF EXISTS `new_system_config`;
CREATE TABLE `new_system_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型（0：数字，1：文本框，2：文本域，3：多选框，4：下拉框）',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组（1：网站配置，2：系统配置，3：其他配置）',
  `extra` varchar(255) DEFAULT '' COMMENT '配置项',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `required` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  KEY `group` (`group`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_system_config
-- ----------------------------
INSERT INTO `new_system_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1509946327', '1', '微信管理平台', '0', '1');
INSERT INTO `new_system_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1509946327', '1', '微信管理平台', '1', '1');
INSERT INTO `new_system_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1509946327', '1', '微信管理平台', '8', '1');
INSERT INTO `new_system_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1378898976', '1509946327', '1', '1', '11', '1');
INSERT INTO `new_system_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '3', '1:系统配置,2:网站配置,3:其他配置', '主要用于数据解析和页面表单的生成', '1378898976', '1508294482', '1', '1,2,3', '2', '1');
INSERT INTO `new_system_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1378900335', '1509946327', '1', 'ICP备', '9', '1');
INSERT INTO `new_system_config` VALUES ('11', 'DOCUMENT_POSITION', '3', '文档推荐位', '3', '1:基本,2:内容,3:用户,4:系统', '文档推荐位，推荐到多个位置KEY值相加即可', '1379053380', '1379235329', '0', '1:列表推荐\r\n2:频道推荐\r\n4:首页推荐', '3', '1');
INSERT INTO `new_system_config` VALUES ('12', 'DOCUMENT_DISPLAY', '3', '文档可见性', '3', '0:关闭,1:开启', '文章可见性仅影响前台显示，后台不收影响', '1379056370', '1379235322', '0', '0:所有人可见\r\n1:仅注册会员可见\r\n2:仅管理员可见', '4', '1');
INSERT INTO `new_system_config` VALUES ('13', 'COLOR_STYLE', '4', '后台色系', '2', 'blue-light:默认,blue:蓝黑,yellow-light:黄色,yellow:黄黑', '后台颜色风格', '1379122533', '1509937061', '1', 'blue-light', '2', '1');
INSERT INTO `new_system_config` VALUES ('20', 'CONFIG_GROUP_LIST', '4', '配置分组', '3', '0:关闭,1:开启', '配置分组', '1379228036', '1508294482', '1', '1', '4', '1');
INSERT INTO `new_system_config` VALUES ('21', 'HOOKS_TYPE', '3', '钩子的类型', '3', '0:关闭,1:开启', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1379313397', '1379313407', '0', '1:视图\r\n2:控制器', '6', '1');
INSERT INTO `new_system_config` VALUES ('22', 'AUTH_CONFIG', '3', 'Auth配置', '3', '0:关闭,1:开启', '自定义Auth.class.php类配置', '1379409310', '1379409564', '0', 'AUTH_ON:1\r\nAUTH_TYPE:2', '8', '1');
INSERT INTO `new_system_config` VALUES ('23', 'COMPLAINT_PHONE', '1', '投诉电话', '1', '0:关闭草稿功能,1:开启草稿功能', '骑士版里的Report center举报中心', '1379484332', '1509946327', '1', '60178320623', '0', '1');
INSERT INTO `new_system_config` VALUES ('24', 'WEB_ADMIN_TITLE', '1', '后台标题', '2', '', '后台系统显示的名称', '1379484574', '1509946287', '1', '微信管理平台', '1', '1');
INSERT INTO `new_system_config` VALUES ('25', 'LIST_ROWS', '0', '每页记录数', '2', '', '后台数据每页显示记录数', '1379503896', '1509937061', '1', '10', '3', '1');
INSERT INTO `new_system_config` VALUES ('26', 'JS_VERSION', '0', 'JS版本', '2', '', 'JS文件更新时需要修改此配置', '1379504487', '1509937061', '1', '1.0', '4', '1');
INSERT INTO `new_system_config` VALUES ('27', 'CSS_VERSION', '0', 'CSS版本', '2', '', 'CSS文件更新时需要修改此配置', '1379814385', '1509937061', '1', '1.0', '4', '1');
INSERT INTO `new_system_config` VALUES ('38', 'GST', '0', '消费税GST', '1', '', '消费税GST=(产品小计和)×GST%,单位\'%\'', '1509932928', '1509946327', '1', '6', '0', '1');
INSERT INTO `new_system_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '2', '', '路径必须以 / 结尾', '1381482411', '1486439645', '0', './Data/', '5', '1');
INSERT INTO `new_system_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '2', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1486439645', '0', '20971520', '7', '1');
INSERT INTO `new_system_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '数据库备份文件是否启用压缩', '2', '0:不压缩,1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1486439645', '0', '1', '9', '1');
INSERT INTO `new_system_config` VALUES ('31', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '2', '1:普通,4:一般,9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1381713408', '1486439645', '0', '9', '10', '1');
INSERT INTO `new_system_config` VALUES ('32', 'DEVELOP_MODE', '4', '开启开发者模式', '2', '0:关闭,1:开启', '是否开启开发者模式', '1383105995', '1486439645', '0', '1', '11', '1');
INSERT INTO `new_system_config` VALUES ('33', 'ALLOW_VISIT', '3', '不受限控制器方法', '0', '1:基本,2:内容,3:用户,4:系统', '', '1386644047', '1386644741', '0', '0:article/draftbox\r\n1:article/mydocument\r\n2:Category/tree\r\n3:Index/verify\r\n4:file/upload\r\n5:file/download\r\n6:user/updatePassword\r\n7:user/updateNickname\r\n8:user/submitPassword\r\n9:user/submitNickname\r\n10:file/uploadpicture', '0', '1');
INSERT INTO `new_system_config` VALUES ('34', 'DENY_VISIT', '3', '超管专限控制器方法', '0', '1:基本,2:内容,3:用户,4:系统', '仅超级管理员可访问的控制器方法', '1386644141', '1386644659', '0', '0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook\r\n4:Admin/getMenus\r\n5:Admin/recordList\r\n6:AuthManager/updateRules\r\n7:AuthManager/tree', '0', '1');
INSERT INTO `new_system_config` VALUES ('35', 'CUSTOM_TELEPHONE', '1', '客服电话', '1', '', '客户端/骑士版对应订单页面右上角的的客服电话', '1386645376', '1509946327', '1', '60178320623', '0', '1');
INSERT INTO `new_system_config` VALUES ('36', 'DELIVERY_RANGE', '0', '配送范围', '1', '', '以客户为圆心的半径距离 单位 KM、公里', '1387165454', '1509946327', '1', '10', '0', '1');
INSERT INTO `new_system_config` VALUES ('37', 'FULL_SCREEN', '4', '全屏模式', '2', '0:关闭,1:开启', '是否开启页面全屏显示', '1387165685', '1509937061', '1', '1', '1', '1');
INSERT INTO `new_system_config` VALUES ('5', 'WEB_SITE_COPYRIGHT', '1', '版权所有', '1', '', '', '1386645376', '1509946327', '1', 'BBM', '0', '1');
INSERT INTO `new_system_config` VALUES ('6', 'WEB_SITE_COPYRIGHT_LINK', '1', '版权跳转页面', '1', '', '点击版权所有时跳转的页面', '0', '1509946327', '1', 'http://www.bbmmarin.com', '0', '1');

-- ----------------------------
-- Table structure for new_system_menu
-- ----------------------------
DROP TABLE IF EXISTS `new_system_menu`;
CREATE TABLE `new_system_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '菜单名',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类Id  顶级菜单默认0',
  `url` varchar(100) DEFAULT NULL COMMENT 'url',
  `params` varchar(50) DEFAULT NULL,
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `icon` varchar(50) DEFAULT NULL COMMENT '图标',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 禁用 1启用',
  `create_by` int(10) unsigned NOT NULL COMMENT '创建人',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_by` int(10) unsigned DEFAULT NULL COMMENT '更新人',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='后台菜单管理';

-- ----------------------------
-- Records of new_system_menu
-- ----------------------------
INSERT INTO `new_system_menu` VALUES ('1', '系统管理', '0', '#', '', '100', 'fa fa-cogs', '1', '1', '1490599201', '1', '1508303980');
INSERT INTO `new_system_menu` VALUES ('2', '系统用户', '1', 'user/index', '', '1', 'fa fa-group', '1', '1', '1490599201', '1', '1508231531');
INSERT INTO `new_system_menu` VALUES ('3', '角色管理', '1', 'role/index', '', '2', 'fa fa-drupal', '1', '1', '1490599201', '1', '1508231612');
INSERT INTO `new_system_menu` VALUES ('4', '菜单管理', '1', 'menu/index', '', '3', 'fa fa-align-left', '1', '1', '1490599201', '1', '1508231584');
INSERT INTO `new_system_menu` VALUES ('5', '参数配置', '1', 'config/index', '', '4', 'fa fa-cogs', '0', '1', '1490599201', '1', '1508231560');
INSERT INTO `new_system_menu` VALUES ('7', '关注回复', '6', 'wechat-reply/subscribe', '', '1', '', '1', '1', '1490599201', '1', '1508231470');
INSERT INTO `new_system_menu` VALUES ('8', '多图文管理', '11', 'wechat-articles/index', '', '2', 'fa fa-list-alt', '1', '1', '1490599201', '1', '1510037803');
INSERT INTO `new_system_menu` VALUES ('9', '微信管理', '0', '#', '', '0', 'fa fa-wechat', '1', '1', '1490599201', '1', '1509957362');
INSERT INTO `new_system_menu` VALUES ('10', '公众号管理', '9', 'wechat-config/index', '', '1', 'fa fa-child', '1', '1', '1490599201', '1', '1509957424');
INSERT INTO `new_system_menu` VALUES ('11', '图文管理', '0', '#', '', '1', '', '1', '1', '1490599201', '1', '1509947750');
INSERT INTO `new_system_menu` VALUES ('12', '文章管理', '11', 'wechat-article/index', '', '0', '', '1', '1', '1490599201', '1', '1510037056');
INSERT INTO `new_system_menu` VALUES ('6', '自动回复', '0', '#', null, '99', null, '1', '1', '1490599201', null, null);

-- ----------------------------
-- Table structure for new_system_role
-- ----------------------------
DROP TABLE IF EXISTS `new_system_role`;
CREATE TABLE `new_system_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '角色名',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `create_by` int(10) unsigned NOT NULL COMMENT '创建人',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_by` int(10) unsigned DEFAULT NULL COMMENT '更新人',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_system_role
-- ----------------------------
INSERT INTO `new_system_role` VALUES ('1', '系统管理员', '1', '1', '1490598947', '1', '1509956814');

-- ----------------------------
-- Table structure for new_system_role_access
-- ----------------------------
DROP TABLE IF EXISTS `new_system_role_access`;
CREATE TABLE `new_system_role_access` (
  `role_id` int(10) unsigned NOT NULL COMMENT '角色组ID',
  `path` char(80) NOT NULL COMMENT '路径',
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_system_role_access
-- ----------------------------

-- ----------------------------
-- Table structure for new_system_user
-- ----------------------------
DROP TABLE IF EXISTS `new_system_user`;
CREATE TABLE `new_system_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `pwd` char(32) NOT NULL,
  `realname` varchar(20) NOT NULL COMMENT '真实姓名',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `role_id` tinytext COMMENT '角色ID',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '用户状态',
  `password_hash` varchar(30) DEFAULT NULL COMMENT '密码安全字段',
  `create_by` int(10) unsigned NOT NULL COMMENT '创建人',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_by` int(10) unsigned DEFAULT NULL COMMENT '更新人',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of new_system_user
-- ----------------------------
INSERT INTO `new_system_user` VALUES ('1', 'admin', '1adb1ac19d3c529773266167273da230', '管理员', '/moreFun/application/admin/web/assets/upload/bd5461fce8bfeb13.jpg', '1', '1', '6379', '1', '1490599201', '1', '1490771348');

-- ----------------------------
-- Table structure for new_wechat_article
-- ----------------------------
DROP TABLE IF EXISTS `new_wechat_article`;
CREATE TABLE `new_wechat_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '素材标题',
  `local_url` varchar(300) DEFAULT NULL COMMENT '永久素材显示URL',
  `show_cover_pic` tinyint(4) unsigned DEFAULT '0' COMMENT '是否显示封面 0不显示，1 显示',
  `author` varchar(20) DEFAULT NULL COMMENT '作者',
  `digest` varchar(300) DEFAULT NULL COMMENT '摘要内容',
  `content` longtext COMMENT '图文内容',
  `content_source_url` varchar(200) DEFAULT NULL COMMENT '图文消息原文地址',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '是否删除(0:不删除  1:删除)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='微信素材表';

-- ----------------------------
-- Records of new_wechat_article
-- ----------------------------
INSERT INTO `new_wechat_article` VALUES ('1', '微信 (WeChat) 是腾讯公司于2011年1月21日推出的一个为智能终端提供即时通讯服务的免费应', 'http://static.cdn.cuci.cc/2016/0510/d47f47a2ecb5bf72347d425384698dab.jpg', '1', 'Anyon', '微信(WeChat)是腾讯公司于2011年1月21日推出的一个为智...', '<p>1231231</p>', '', '2016-04-14 10:47:16', '1', '0');
INSERT INTO `new_wechat_article` VALUES ('2', '从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就', 'http://static.cdn.cuci.cc/2016/0523/7a6731fc42569f05e9a5f281e74353d3.jpg', '1', '大小姐', '从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想', '<p><span style=\";font-family:宋体;font-size:16px\">从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：</span></p><p><br/></p>', '从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：', '2016-05-24 14:31:08', '1', '0');
INSERT INTO `new_wechat_article` VALUES ('4', '阿斯蒂芬前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大', 'http://localhost/wechat/application/admin/web/assets/upload/bc31f218739d5995.jpg', '0', '阿凡达', '萨芬的前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：', '<p><img src=\"/ueditor/php/upload/image/20171110/1510294239347610.png\" title=\"1510294239347610.png\" alt=\"QQ截图20161108093848.png\"/>萨芬的<br/></p>', '从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故事，大和尚就说：从前有一座山，山里有座庙，庙里有两个和尚，大和尚和小和尚，小和尚对大和尚说：我想听你讲故', '2016-05-24 15:00:32', '1', '1');
INSERT INTO `new_wechat_article` VALUES ('7', '我们观察了17000家企业，发现了这个秘密', '/wechat/application/admin/web/assets/upload/1fa8d59df7d55b18.png', '0', '阿帆', '阿帆', '<p>的萨芬<br/></p>', '阿萨德发放', '2016-05-26 17:12:20', '1', '1');
INSERT INTO `new_wechat_article` VALUES ('8', '测试图文测试图文测试图文测试图文测试图文测试图文', 'http://static.cdn.cuci.cc/2016/0615/e773bee88170eb2c25272f6bf9481536.JPG', '0', 'eeeeee个', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', '<p style=\"text-align: center;\">2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222</p>', '', '2016-06-15 16:22:07', '1', '1');
INSERT INTO `new_wechat_article` VALUES ('9', '{{nickname}}  小丸子小丸子小丸子小丸子小丸子小丸子50', 'http://static.cdn.cuci.cc/2016/0421/f777421494f26e357583b76d983371ad.jpeg', '0', '椪柑椪柑椪柑', '我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃...', '<p>我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子我是樱桃小丸子</p>', '', '2016-06-16 10:37:09', '1', '0');
INSERT INTO `new_wechat_article` VALUES ('11', 'e哈哈eeeee哈哈eeeeeee哈哈', 'http://static.cdn.cuci.cc/2016/0421/f6c982e63c19e9fd1fbdc82fad6a3f14.jpg', '0', '哈哈llllllllllllllllll', 'fffffffffffffffffffffffffffffffffffffffffffffffffff...', '<p>1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111</p>', '', '2016-06-16 10:54:17', '1', '1');
INSERT INTO `new_wechat_article` VALUES ('12', '啊啊啊啊啊啊啊啊啊啊', 'http://static.cdn.cuci.cc/2016/0421/4faafa35a48ef1f3fa9cfcedb5eb24aa.jpeg', '0', 'muuu', '哈哈哈哈哈哈哈哈哈哈哈哈和哈哈哈哈哈哈哈哈哈哈哈哈...', '<p>哈哈哈哈哈哈哈哈哈哈哈哈和哈哈哈哈哈哈哈哈哈哈哈哈和和鹅鹅鹅饿鹅鹅鹅鹅鹅鹅鹅鹅鹅和鹅鹅鹅饿鹅鹅鹅鹅鹅鹅鹅鹅鹅嗯嗯嗯和鹅鹅鹅饿鹅鹅鹅饿鹅鹅鹅饿鹅鹅鹅饿啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊的撒擦撒大神大神大神大神的发生的方法vsafas</p>', '', '2016-06-16 14:14:45', '1', '0');

-- ----------------------------
-- Table structure for new_wechat_articles
-- ----------------------------
DROP TABLE IF EXISTS `new_wechat_articles`;
CREATE TABLE `new_wechat_articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '永久素材显示URL',
  `article_id` varchar(60) DEFAULT NULL COMMENT '关联图文ID，用，号做分割',
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`),
  KEY `index_wechat_new_artcle_id` (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='微信图文表';

-- ----------------------------
-- Records of new_wechat_articles
-- ----------------------------
INSERT INTO `new_wechat_articles` VALUES ('1', 'ajnLDi8svSvAH8Fq3h9FPW_SwSgJWLS4ytgO7d-O1IA', null, '2,7,1,8', '1', '2016-04-14 10:47:41', '10000');
INSERT INTO `new_wechat_articles` VALUES ('2', 'ajnLDi8svSvAH8Fq3h9FPXuPxhjCIXxMQCCRRXSK9gs', null, '1,2,9,12,11,7', '1', '2016-05-06 09:49:24', '10000');
INSERT INTO `new_wechat_articles` VALUES ('17', 'ajnLDi8svSvAH8Fq3h9FPY01qkdVprjOtZI6_g4iv4o', null, '2,9', '0', '2016-06-09 15:15:54', '10000');
INSERT INTO `new_wechat_articles` VALUES ('18', 'ajnLDi8svSvAH8Fq3h9FPcAETCl60Wx5lLxRLNnDWHE', null, '2,9,12,8,7', '0', '2016-06-15 16:29:26', '10000');
INSERT INTO `new_wechat_articles` VALUES ('19', null, null, '2,4,7,11,12,1', '0', '2017-11-08 15:44:53', '1');
INSERT INTO `new_wechat_articles` VALUES ('20', null, null, '8', '0', '2017-11-09 13:24:24', '1');
INSERT INTO `new_wechat_articles` VALUES ('21', null, null, '9', '0', '2017-11-09 13:32:43', '1');

-- ----------------------------
-- Table structure for new_wechat_config
-- ----------------------------
DROP TABLE IF EXISTS `new_wechat_config`;
CREATE TABLE `new_wechat_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '公众号名称',
  `qrc_img` varchar(100) DEFAULT NULL COMMENT '二维码',
  `token` varchar(100) DEFAULT NULL COMMENT '接口token',
  `appid` varchar(100) DEFAULT NULL COMMENT '高级调用功能的app id',
  `encodingaeskey` varchar(100) DEFAULT NULL COMMENT '加密用的encodingaeskey',
  `appsecret` varchar(100) DEFAULT NULL COMMENT '高级调用功能的密钥',
  `mch_appid` varchar(100) DEFAULT NULL COMMENT '支付公众号Appid',
  `mch_id` varchar(100) DEFAULT NULL COMMENT '商户身份标识',
  `partnerkey` varchar(100) DEFAULT NULL COMMENT '商户权限密钥',
  `ssl_cer` varchar(500) DEFAULT NULL COMMENT '商户证书CER',
  `ssl_key` varchar(500) DEFAULT NULL COMMENT '商户证书KEY',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT '公众号类型',
  `subscribe_url` varchar(255) DEFAULT NULL COMMENT '引导关注页面链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_wechat_config
-- ----------------------------
INSERT INTO `new_wechat_config` VALUES ('10000', '测试号', null, 'token', 'wx2020bf7cccf0e197', '', 'a829ca7aaf25ed645db5aa7c4fe5904b', null, null, null, null, null, '2017-10-18 16:31:06', '1', '');

-- ----------------------------
-- Table structure for new_wechat_keyword
-- ----------------------------
DROP TABLE IF EXISTS `new_wechat_keyword`;
CREATE TABLE `new_wechat_keyword` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL COMMENT '类型，text 文件消息，image 图片消息，news 图文消息',
  `keys` varchar(100) DEFAULT NULL COMMENT '关键字',
  `content` text COMMENT '文本内容',
  `image_url` varchar(255) DEFAULT NULL COMMENT '图片链接',
  `voice_url` varchar(255) DEFAULT NULL COMMENT '语音链接',
  `music_title` varchar(100) DEFAULT NULL COMMENT '音乐标题',
  `music_url` varchar(255) DEFAULT NULL COMMENT '音乐链接',
  `music_image` varchar(255) DEFAULT NULL COMMENT '音乐缩略图链接',
  `music_desc` varchar(255) DEFAULT NULL COMMENT '音乐描述',
  `video_title` varchar(100) DEFAULT NULL COMMENT '视频标题',
  `video_url` varchar(255) DEFAULT NULL COMMENT '视频URL',
  `video_desc` varchar(255) DEFAULT NULL COMMENT '视频描述',
  `news_id` bigint(20) unsigned DEFAULT NULL COMMENT '图文ID',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '0 禁用，1 启用',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT=' 微信关键字';

-- ----------------------------
-- Records of new_wechat_keyword
-- ----------------------------
INSERT INTO `new_wechat_keyword` VALUES ('1', 'news', 'subscribe', '欢迎 {{nickname}} 关注<a href=\'http://www.qq.com\'>TEST</a>！', 'http://static.cdn.cuci.cc/2016/0420/b46c54ff5d37d70cf85dcbf53c8b5db7.jpg', 'http://static.cdn.cuci.cc/2016/0512/f8eb037d00680ee07f03642c71464751.mp3', '测试音乐', 'http://static.cdn.cuci.cc/2016/0512/baedefec66970834c0642737d5254dae.mp3', 'http://static.cdn.cuci.cc/2016/0512/2718b13a4eb6d96c94843019c63231e6.jpg', 'test music', '测试视频', 'http://static.cdn.cuci.cc/2016/0512/43cd807954bf57bc2bfc57b9646bbabe.mp4', '测试视频', '1', '1', '10000', '2017-11-15 10:17:31');

-- ----------------------------
-- Table structure for new_wechat_news_image
-- ----------------------------
DROP TABLE IF EXISTS `new_wechat_news_image`;
CREATE TABLE `new_wechat_news_image` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(200) DEFAULT NULL COMMENT '公众号ID',
  `md5` varchar(32) DEFAULT NULL COMMENT '文件md5',
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT NULL COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信服务器图片';

-- ----------------------------
-- Records of new_wechat_news_image
-- ----------------------------

-- ----------------------------
-- Table structure for new_wechat_news_media
-- ----------------------------
DROP TABLE IF EXISTS `new_wechat_news_media`;
CREATE TABLE `new_wechat_news_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(200) DEFAULT NULL COMMENT '公众号ID',
  `md5` varchar(32) DEFAULT NULL COMMENT '文件md5',
  `type` varchar(20) DEFAULT NULL COMMENT '媒体类型',
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT NULL COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='微信素材表';

-- ----------------------------
-- Records of new_wechat_news_media
-- ----------------------------
INSERT INTO `new_wechat_news_media` VALUES ('18', 'wx3581ccf368729be3', '426a00b6e6e3ba0cbf64be44330b795f', 'image', 'ajnLDi8svSvAH8Fq3h9FPXVxWYJCcfLKnIJqnmxTB9Q', 'http://static.cdn.cuci.cc/2016/0518/5af254eee9eff4787376ba9c3d87c900.jpg', 'http://mmbiz.qpic.cn/mmbiz_jpg/DIYOdibia7apQsLKJ3c72dlMZdOCTIIqoTrZT1Yxficfu64WfkvhpVibatjA8j26ahRibDNQZ158T3YFaYVXbogN0yg/0?wx_fmt=jpeg', '2016-08-30 13:05:45');
INSERT INTO `new_wechat_news_media` VALUES ('19', 'wx3581ccf368729be3', 'ab5d5cf8a6128090858ec4a3e998ea0a', 'image', 'ajnLDi8svSvAH8Fq3h9FPeJM9JAHrXf8V6uFcxFbPhY', 'http://static.cdn.cuci.cc/2016/0511/284be4c57b6d68a46b562c7e9ef1f19e.jpg', 'http://mmbiz.qpic.cn/mmbiz_jpg/DIYOdibia7apQsLKJ3c72dlMZdOCTIIqoTEt8fe5w4XcoiaJFZqbqKGicjYApWiba7vqNBFho2DTtwPVUuiaRopBycEg/0?wx_fmt=jpeg', '2016-08-30 13:07:46');
INSERT INTO `new_wechat_news_media` VALUES ('20', 'wx3581ccf368729be3', 'a88075113cb60d8913ccee28e3333b2f', 'video', 'ajnLDi8svSvAH8Fq3h9FPdn6JoeQ030tQkQ3aLOEvxE', 'http://static.cdn.cuci.cc/2016/0427/4ccedb80d5b4d453011cdc2ab22902be.mp4', null, '2016-08-30 13:09:22');
INSERT INTO `new_wechat_news_media` VALUES ('21', 'wx3581ccf368729be3', '30a824835c03a1fa5763e04b0046b02e', 'image', 'ajnLDi8svSvAH8Fq3h9FPU8gxJvhJBNJvphROc8yX3g', 'http://static.cdn.cuci.cc/2016/0512/a92eb4c8ea07443174cb1c428700c89e.jpg', 'http://mmbiz.qpic.cn/mmbiz_jpg/DIYOdibia7apQsLKJ3c72dlMZdOCTIIqoTAIDZuS8BH3iantAlJtv6aU1FsiaBh49G5Jq9OUzTqGE09icv5UHPvzDVg/0?wx_fmt=jpeg', '2016-08-30 13:10:11');
INSERT INTO `new_wechat_news_media` VALUES ('22', 'wx3581ccf368729be3', 'ee792dc55368bc96abb111adbf8e7f4f', 'image', 'ajnLDi8svSvAH8Fq3h9FPb-5or-8hV0sZnNZU_ezajo', 'http://static.cdn.cuci.cc/2016/0523/7a6731fc42569f05e9a5f281e74353d3.jpg', 'http://mmbiz.qpic.cn/mmbiz_jpg/DIYOdibia7apQsLKJ3c72dlMZdOCTIIqoTCeJrNEHwoQHbIWlFh42oxukQiaU98CBU53ibuFnVw9LjXDG8MsWmYFxw/0?wx_fmt=jpeg', '2016-08-30 13:18:32');
