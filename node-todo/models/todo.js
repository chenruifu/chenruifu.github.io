var Sequelize = require('sequelize');
var sequelize = require('../db/connect.js');

const todolist = sequelize.define('todolist',{
    id: {
        type: Sequelize.BIGINT(11),
        primaryKey: true,
        allowNull: false,
        unique: true,
        autoIncrement: true
    },
    // 标题
    title: {
        type: Sequelize.STRING(100), // 标题
        allowNull: false
    },
    // 详细内容
    content: {
        type: Sequelize.STRING(500),
        allowNull: false
    },
    // 状态: -1删除、0待办、1完成
    status: {
        type: Sequelize.STRING(500), 
        defaultValue: 0
    },
    //结束时间
    end_time: Sequelize.STRING(100),
},{
    timestamps: false //不加载默认时间戳
});

module.exports = todolist;