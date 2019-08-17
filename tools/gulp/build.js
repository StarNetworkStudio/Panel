var colors = require('colors');

confPath = './../build.json';
var d = new Date();
var t = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
console.log('[' + t.grey + ']' + ' ' + 'Using config ' + confPath.green);
module.exports = require(confPath);
