import './bootstrap';

// --- ここからjQueryの追加 ---
import $ from 'jquery';
window.jQuery = window.$ = $; // グローバルスコープにjQueryと$を公開

import './components/click_row';
import './components/destroy_modal';
import './components/flash_messages'; 
import './components/modal_handler';
import './components/user_confirm_modal'; 