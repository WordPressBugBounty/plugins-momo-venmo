<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$email_html = '';
// $order = wc_get_order( $order_id );
$amount = $order->get_total();
$currency = $order->get_currency();
// $total = "$amount $currency";
// $total = $order->get_total();
$total = $order->get_formatted_order_total();
$note = sprintf( esc_html__( 'Order %1s checkout at %2s', WCVENMO_PLUGIN_TEXT_DOMAIN ), $order_id, get_site_url() );
$payment_url = $this->wc_venmo_payment_url( $amount, $note );
$qr_code_url = $this->wc_venmo_qrcode_url( $amount, $note );
$qr_code = $this->wc_venmo_qrcode_html( $amount, $note );
$email_html .= '<h2>' . esc_html__( 'Venmo Notice', WCVENMO_PLUGIN_TEXT_DOMAIN ) . '</h2>';
$email_html .= '<p>' . esc_html__( 'Send', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' <a style="color: #3396cd" href="' . $payment_url . '" target="_blank">' . esc_html__( 'the requested total to', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' ' . esc_attr( wp_kses_post( $this->ReceiverVenmo ) ) . '</a> ' . esc_html__( 'or click the Venmo button below', WCVENMO_PLUGIN_TEXT_DOMAIN ) . '</p>';
$email_html .= '<p><a href="' . $payment_url . '" target="_blank"><img width="150" height="150" alt="Venmo link" src="' . esc_url( WCVENMO_PLUGIN_DIR_URL . 'assets/images/venmo.png' ) . '"></a></p>';
if ( !empty( $order_id ) ) {
    $email_html .= '<p>' . esc_html__( 'Payment Reference / Order Number', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ': ' . $order_id . '</p>';
}
echo $email_html;