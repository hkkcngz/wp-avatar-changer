# wp-avatar-changer
Wordpress Simple Front-end Avatar Changer Plugin. 

# Usage
Add this shortcode before get_header in page where you want to show user avatar. 

```
$userAvatar = get_user_meta($user_id,'userAvatar',true);
```

```
<img src="<?=$userAvatar?>" alt="" />
```
