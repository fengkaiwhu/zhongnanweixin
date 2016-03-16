drop table if exists smsMessage;
create table `smsMessage`(
    `id` int(12) NOT NULL auto_increment,
    `telephone` varchar(12) default NULL COMMENT '电话',
    `mid` varchar(35) default NULL COMMENT '消息id(消息唯一标识)',
    `time` int(11) default NULL COMMENT '消息创建时间',
    `verifynum` int(7) default NULL COMMENT '验证码',
    `used` tinyint(1) default false COMMENT '是否已经验证',
    primary key(`id`)
)engine=MyISAM default charset=utf8;
