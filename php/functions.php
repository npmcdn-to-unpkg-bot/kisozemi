<?php
/* http://qiita.com/mpyw/items/bb8305ba196f5105be15 */

ini_set("display_errors", On);
error_reporting(E_ALL);
/**
 * ログイン状態によってリダイレクトを行うsession_startのラッパー関数
 * 初回時または失敗時にはヘッダを送信してexitする
 */
function require_unlogined_session() {
    // セッション開始
    @session_start();
    // ログインしていれば / に遷移
    if (isset($_SESSION['screen_name'])) {
        header('Location: ./');
        exit;
    }
}
function require_logined_session() {
    // セッション開始
    @session_start();
    // ログインしていなければ /login.php に遷移
    if (!isset($_SESSION['screen_name'])) {
        header('Location: ./login');
        exit;
    }
}

/**
 * CSRFトークンの生成
 *
 * @return string トークン
 */
function generate_token() {
    // セッションIDからハッシュを生成
    return hash('sha256', session_id());
}

/**
 * CSRFトークンの検証
 *
 * @param string $token
 * @return bool 検証結果
 */
function validate_token($token) {
    // 送信されてきた$tokenがこちらで生成したハッシュと一致するか検証
    return $token === generate_token();
}

/**
 * htmlspecialcharsのラッパー関数
 *
 * @param string $str
 * @return string
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
