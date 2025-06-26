import './bootstrap';

// --- ここからjQueryの追加 ---
import $ from 'jquery';
window.jQuery = window.$ = $; // グローバルスコープにjQueryと$を公開

//お試し
$(function() { 
    console.log("jQuery is successfully loaded!");
    $('body').on('click', function() {
        console.log('Body was clicked!');
    });
});