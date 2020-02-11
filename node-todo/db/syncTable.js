const todolist = require('../models/todo');

todolist.sync({
    force: true 
})