<?php
/*
Plugin Name: AddNumberPost
Plugin URI:
Description: 投稿自動採番
Version: 1.0.0
Author:Keita Saito
Author URI: http://z-tree.jp
License: GPL2
*/
?>


<?php
/*  Copyright 2017 Keita Saito (email : saito@z-tree.jp)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>

<?php
function post_counts(){

    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;
}



//採番用のカスタムフィールド追加
function add_custom_field($post_id,$number){
   add_post_meta($post_id,'number',$number,true);
}

//プラグイン起動時に採番されているかの処理
function check_post_Number(){
    $args = array(
            'order' => 'ASC'
            );
    $query = new WP_Query($args);
    global $post;
    $number = 0;
    if($query->have_posts()){
        while($query->have_posts()){
            $query->the_post();
            $post_id = $post->ID;
            if(get_post_meta($post_id,'number',true) == '' ){
            $number++;
            add_custom_field($post_id,$number);
            }else{
            $number++;
            }
        }
    }
    wp_reset_postdata();
}

add_filter('init','check_post_Number');
?>
