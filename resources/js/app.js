import './bootstrap';

// --- ここからjQueryの追加 ---
import $ from 'jquery';
window.jQuery = window.$ = $; // グローバルスコープにjQueryと$を公開

import './components/flash_messages'; 
import './components/modal_handler';