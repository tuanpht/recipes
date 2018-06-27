<?php
/* (c) Tuan Pham <tuanpt216@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Deployer;

use Deployer\Utility\Httpie;

set('chatwork_api_token', function () {
    throw new \Exception('Please, configure "chatwork_api_token" parameter.');
});

set('chatwork_room_id', function () {
    throw new \Exception('Please, configure "chatwork_room_id" parameter.');
});

set('chatwork_base_api_url', 'https://api.chatwork.com/v2');
set(
    'chatwork_message',
    "TO ALL >>>\n[info][title]{{repo.owner}}/{{repo.name}}#{{build.commit}} {{build.status}}[/title]"
        . "Branch: {{build.branch}}\nAuthor: {{build.author}}\nMessage: {{build.message}}[/info]"
);

desc('Notifying Chatwork');
task('chatwork:notify', function () {
    $api = sprintf('%s/rooms/%s/messages', get('chatwork_base_api_url'), get('chatwork_room_id'));
    $result = Httpie::post($api)
        ->header('X-ChatWorkToken: ' . get('chatwork_api_token'))
        ->form([
            'body' => get('chatwork_message'),
        ])
        ->getJson();

    if (isset($result['errors'])) {
        writeln('--> <fg=red>Failed to send message: ' . implode(PHP_EOL, $result['errors']) . '</fg=red>');
    } elseif (isset($result['message_id'])) {
        writeln('--> <fg=yellow>Successfully sent message ' . $result['message_id'] . '</fg=yellow>');
    } else {
        writeln('--> <fg=red>Failed to send message: Unknown error!</fg=red>');
    }
})
->once()
->setPrivate();
