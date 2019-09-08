<?php
namespace Deployer;

require 'recipe/laravel.php';

set('application', 'Admin_Panel');

set('repository', 'git@github.com:starnetworkstudio/Panel.git');

set('git_tty', true);

add('shared_files', []);
add('shared_dirs', ['resources/assets/dist']);
add('writable_dirs', []);

// 保存最近五次部署，这样的话回滚最多也只能回滚到前 5 个版本
set('keep_releases', 5);

// 实践证明，这样能减少一些不必要的麻烦,如出现权限相关的问题，也可将此项设置为 true 后尝试
set('writable_use_sudo', false);

// composer 选项
set('composer_options', 'install --no-interaction --prefer-dist');

host('hk.starskim.com')
    ->user('root')
    ->port(22)
    ->set('branch', 'dev')
    ->set('deploy_path', '/data/wwwroot/admin.dev.starskim.top')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->set('http_user', 'www');

// Tasks
desc('Deploy super-miner-proxy project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:yarn',
    'deploy:writable',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:optimize',
    'artisan:migrate',
    'deploy:chown',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// 定义一个前端编译的任务
desc('Yarn');
task('deploy:yarn', function () {
    run('cd {{release_path}}/tools && yarn && gulp build', ['timeout' => 600]);
});

// 设置文件权限
desc('Website root permissions');
task('deploy:chown', function () {
    run('chown -R www.www /data/wwwroot/ && find /data/wwwroot/ -type d -exec chmod 755 {} \; && find /data/wwwroot/ -type f -exec chmod 644 {} \;', ['timeout' => 600]);
});

// 如果部署失败，自动解除部署锁定状态，以免影响下次执行
after('deploy:failed', 'deploy:unlock');
