const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const todoModel = require('./models/todo')

// 中间件请求参数，res.body
app.use(bodyParser.urlencoded({ extended: false }))

// 创建数据
app.post('/create', async (req, res, next) => {
    try {
        let { title, content, end_time } = req.body;
        let create = await todoModel.create({
            title,
            content,
            end_time
        })
        res.json({
            status: 1,
            msg: '创建成功'
        }) 
    } catch (error) {
        next(error);
    }
})
// 删除数据
app.post('/delete', async (req, res, next) => {
    try {
        let { id } = req.body;
        let json = await todoModel.findOne({ 
            where: {id} 
        })
        if(json) {
            json.status = -1,
            await json.save();
            res.json({
                status: 1,
                msg: '删除成功',
                json
            }) 
        }else{
            res.json({
                status: 1,
                msg: '该id不存在'
            }) 
        }
    } catch (error) {
        next(error);
    }
})
// 修改数据
app.post('/update', async (req, res, next) => {
    try {
        let { title, content, end_time, id } = req.body;
        let json = await todoModel.findOne({ 
            where: {id} 
        })
        if(json) {
            title && (json.title = title);
            content && (json.content = content);
            end_time && (json.end_time = end_time);
            status && (json.status = status);
            await json.save();
            res.json({
                status: 1,
                msg: '修改成功',
                json
            }) 
        }else{
            res.json({
                status: 1,
                msg: '该id不存在'
            }) 
        }
    } catch (error) {
        next(error);
    }
})
// 获取数据
app.get('/list', async (req, res, next) => {
    try{
        let limit = 10;
        let { page = 1, status = ''} = req.body;
        page = page < 1 ? 1 : page;
        let offset = (page - 1) * limit;
        console.log(offset)
        let where = {};
        if(status !== ''){
            where = {
                status
            }
        }
        let list = await todoModel.findAndCountAll({
            where,
            offset,
            limit
        })
        res.json({
            status: 1,
            msg: '查询成功',
            count: list.count,
            list: list.rows
        })
    }catch(error) {
        next(error);
    }
    
})
// 统一错误处理
app.use((err, req, res, next) => {
    if(err) {
        res.status(500).json({
            status: 0,
            msg: err.message
        })
    }
})

const server = app.listen(8899, function() {
    console.log('启动成功，端口号8899');
});