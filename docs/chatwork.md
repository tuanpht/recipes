# Chatwork recipe

## Installing
  1. Get API token from https://www.chatwork.com/service/packages/chatwork/subpackages/api/token.php
  2. Get room id of room you or your bot participated in to post message

Require chatwork recipe in your `deploy.php` file:

```php
require 'recipe/chatwork.php';
```

## Configuration

- `chatwork_api_token` – chatwork api token, **required**
- `chatwork_room_id` — room ID to push messages to, **required**
- `chatwork_message` – the message body template, default:
  ```
  TO ALL >>>\n[info][title]{{repo.owner}}/{{repo.name}}#{{build.commit}} {{build.status}}[/title]Branch: {{build.branch}}\nAuthor: {{build.author}}\nMessage: {{build.message}}[/info]
  ```

## Tasks

- `chatwork:notify` – send message to chatwork

## Usage

If you want to notify only about beginning of deployment add this line only:

```php
before('deploy', 'chatwork:notify');
```

If you want to notify about successful end of deployment add this too:

```php
after('success', 'chatwork:notify:success');
```

