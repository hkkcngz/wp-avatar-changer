# wp-avatar-changer
Wordpress Simple Front-end Avatar Changer Plugin.

 [Demo](https://cayarasi.com "Çay Arası - Bi Dolu Muhabbet") | 
 [Demo 2](https://ders-not.com "Ders-Not")

# Usage
Add this shortcode before get_header in page where you want to show user avatar. 

```
$userAvatar = get_user_meta($user_id,'userAvatar',true);
```

```
<img src="<?=$userAvatar?>" alt="" />
```