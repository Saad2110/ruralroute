<?php
/**
 * Payment methods
 *
 * Shows customer payment methods on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/payment-methods.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

$saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
$has_methods   = (bool) $saved_methods;
$types         = wc_get_account_payment_methods_types();

do_action( 'woocommerce_before_account_payment_methods', $has_methods ); ?>
<h1 class="elementor-heading-title main-heading">Please Enter Your New Card Information</h1>
<?php if ( $has_methods ) : ?>
	<div class="dh-payment-method-table">
	<table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table dh">
		<!-- <thead>
			<tr>
				<?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead> -->
		<?php foreach ( $saved_methods as $type => $methods ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
			<?php foreach ( $methods as $method ) : ?>
				<tr class="payment-method<?php echo ! empty( $method['is_default'] ) ? ' default-payment-method' : ''; ?>">
					<h2 class="elementor-heading-title elementor-size-default">Current Payment Method</h2>
					<td>
						<?php 
							if ( ! empty( $method['method']['last4'] ) ) {
								/* translators: 1: credit card type 2: last 4 digits */
								echo sprintf( esc_html__( '%1$s Ending in %2$s', 'woocommerce' ), esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ), esc_html( $method['method']['last4'] ) );
							}
							echo '<span class="next-payment-date">Next payment on '.do_shortcode('[dh_rr_pickup_subscription_detials data_type=renewaldate]').'</span>';
						?>
					</td>
					<?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
						<!-- <td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php
							if ( has_action( 'woocommerce_account_payment_methods_column_' . $column_id ) ) {
								do_action( 'woocommerce_account_payment_methods_column_' . $column_id, $method );
							} elseif ( 'method' === $column_id ) {
								if ( ! empty( $method['method']['last4'] ) ) {
									/* translators: 1: credit card type 2: last 4 digits */
									// echo sprintf( esc_html__( '%1$s Ending in %2$s', 'woocommerce' ), esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ), esc_html( $method['method']['last4'] ) );
								} else {
									// echo esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) );
								}
							} elseif ( 'expires' === $column_id ) {
								// echo esc_html( $method['expires'] );
							} elseif ( 'actions' === $column_id ) {
								foreach ( $method['actions'] as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
									// echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>&nbsp;';
								}
							}
							?>
						</td> -->
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</table>
	</div>

<?php else : ?>

	<?php wc_print_notice( esc_html__( 'No saved methods found.', 'woocommerce' ), 'notice' ); ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_payment_methods', $has_methods ); ?>

<?php

$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

if ( $available_gateways ) : ?>
	<!--<section class="elementor-section elementor-inner-section elementor-element elementor-element-6a3af4a elementor-section-content-middle elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="6a3af4a" data-element_type="section">
		<div class="elementor-container elementor-column-gap-extended">
			<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-f1108ea" data-id="f1108ea" data-element_type="column">
				<div class="elementor-widget-wrap elementor-element-populated">
					<div class="elementor-element elementor-element-a46f68c elementor-widget elementor-widget-heading" data-id="a46f68c" data-element_type="widget" data-widget_type="heading.default">
						<div class="elementor-widget-container" style="text-align:center;margin-bottom: 100px;">
							<h2 class="elementor-heading-title elementor-size-default" style="color: #000;">Coming Soon</h2>		</div>
					</div>
				</div>
			</div>
		</div>
	</section>-->
	<div class="dh-cc-form-payment-container" style="">
		<form id="add_payment_method" method="post">
			<div id="payment" class="woocommerce-Payment">
				<ul class="woocommerce-PaymentMethods payment_methods methods">
					<div class="form-container dh-pickup">
	        			<div class="field-container">
				            <label for="name">Name</label>
				            <input id="name" maxlength="20" type="text">
				        </div>
				        <div class="field-container">
				            <label for="cardnumber">Card Number</label><span id="generatecard">generate random</span>
				            <input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric">
				            <svg id="ccicon" class="ccicon" width="60" height="40" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg"
				                xmlns:xlink="http://www.w3.org/1999/xlink">

				            </svg>
				        </div>
				        <div class="field-container">
				            <label for="expirationdate">Expiration (mm/yy)</label>
				            <input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric">
				        </div>
				        <div class="field-container">
				            <label for="securitycode">Security Code</label>
				            <input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric">
				        </div>
			    	</div>
					<?php
					// Chosen Method.
					if ( count( $available_gateways ) ) {
						current( $available_gateways )->set_current();
					}

					foreach ( $available_gateways as $gateway ) {
						?>
						<li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $gateway->id ); ?> payment_method_<?php echo esc_attr( $gateway->id ); ?>">
							<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
							<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>"><?php echo wp_kses_post( $gateway->get_title() ); ?> <?php echo wp_kses_post( $gateway->get_icon() ); ?></label>
							<?php
							if ( $gateway->has_fields() || $gateway->get_description() ) {
								echo '<div class="woocommerce-PaymentBox woocommerce-PaymentBox--' . esc_attr( $gateway->id ) . ' payment_box payment_method_' . esc_attr( $gateway->id ) . '" style="display: none;">';
								$gateway->payment_fields();
								echo '</div>';
							}
							?>
						</li>
						<?php
					}
					?>
				</ul>

				<?php do_action( 'woocommerce_add_payment_method_form_bottom' ); ?>

				<div class="form-row">
					<?php wp_nonce_field( 'woocommerce-add-payment-method', 'woocommerce-add-payment-method-nonce' ); ?>
					<button type="submit" class="woocommerce-Button woocommerce-Button--alt button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" id="place_order" value="<?php esc_attr_e( 'Add payment method', 'woocommerce' ); ?>"><?php esc_html_e( 'Add payment method', 'woocommerce' ); ?></button>
					<input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1" />
				</div>
			</div>
		</form>
		<div class="ccd-container preload">
	        <div class="creditcard">
	            <div class="front">
	                <div id="ccsingle"></div>
	                <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
	                    x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
	                    <g id="Front">
	                        <g id="CardBackground">
	                            <g id="Page-1_1_">
	                                <g id="amex_1_">
	                                    <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
	                            C0,17.9,17.9,0,40,0z" />
	                                </g>
	                            </g>
	                            <path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
	                        </g>
	                        <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4">0123 4567 8910 1112</text>
	                        <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6">JOHN DOE</text>
	                        <text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">cardholder name</text>
	                        <text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">expiration</text>
	                        <text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">card number</text>
	                        <g>
	                            <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9">01/23</text>
	                            <text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
	                            <text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
	                            <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
	                        </g>
	                        <g id="cchip">
	                            <g>
	                                <path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
	                        c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
	                            </g>
	                            <g>
	                                <g>
	                                    <rect x="82" y="70" class="st12" width="1.5" height="60" />
	                                </g>
	                                <g>
	                                    <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
	                                </g>
	                                <g>
	                                    <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
	                            c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
	                            C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
	                            c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
	                            c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
	                                </g>
	                                <g>
	                                    <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
	                                </g>
	                                <g>
	                                    <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
	                                </g>
	                                <g>
	                                    <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
	                                </g>
	                                <g>
	                                    <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
	                                </g>
	                            </g>
	                        </g>
	                    </g>
	                    <g id="Back">
	                    </g>
	                </svg>
	            </div>
	            <div class="back">
	                <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
	                    x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
	                    <g id="Front">
	                        <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
	                    </g>
	                    <g id="Back">
	                        <g id="Page-1_2_">
	                            <g id="amex_2_">
	                                <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
	                        C0,17.9,17.9,0,40,0z" />
	                            </g>
	                        </g>
	                        <rect y="61.6" class="st2" width="750" height="78" />
	                        <g>
	                            <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
	                    C707.1,246.4,704.4,249.1,701.1,249.1z" />
	                            <rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
	                            <rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
	                            <path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
	                        </g>
	                        <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7">985</text>
	                        <g class="st8">
	                            <text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">security code</text>
	                        </g>
	                        <rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
	                        <rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
	                        <text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13">John Doe</text>
	                    </g>
	                </svg>
	            </div>
	        </div>
	    </div>
    </div>
<?php else : ?>
	<?php wc_print_notice( esc_html__( 'New payment methods can only be added during checkout. Please contact us if you require assistance.', 'woocommerce' ), 'notice' ); ?>
<?php endif; ?>
