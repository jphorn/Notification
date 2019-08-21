<?php
/**
 * Webhook Carrier
 *
 * @package notification
 */

namespace BracketSpace\Notification\Defaults\Carrier;

use BracketSpace\Notification\Interfaces\Triggerable;
use BracketSpace\Notification\Abstracts;
use BracketSpace\Notification\Defaults\Field;

/**
 * Webhook Carrier
 */
class Webhook extends Abstracts\Carrier {

	/**
	 * Carrier icon
	 *
	 * @var string SVG
	 */
	public $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 402.07 372.81"><path d="M100.7,239.8q23.25-38,46.9-76.5c-22.1-21.5-32.4-47.5-30.2-78,1.7-23.7,11.5-44,28.9-60.5C180-7,232.8-8.4,269,21.6c36.6,30.3,44.7,82.2,22.8,119.7-8.2-4.8-16.5-9.5-25.1-14.5,9.5-20.3,9.7-40.5-.5-60.5a63.54,63.54,0,0,0-34.4-31.1c-29.3-11.5-61.2.6-76.3,28.3-14.3,26.3-9.1,72,32.8,91.6-20.8,33.9-41.7,67.7-62.4,101.5,11.5,20,6.8,40.2-7.7,52.3-13,10.9-31.3,11.7-45.6,2.2A39.54,39.54,0,0,1,56.4,267C61.9,248.4,75.3,240.1,100.7,239.8Z" transform="translate(0.01 0.01)"/><path d="M90.9,184.8v28.9c-20.6,2.5-37.2,12.1-48.8,29.8-9,13.7-12.2,28.7-10.3,44.9a60.28,60.28,0,0,0,58.7,53.2c20.7.4,38-7.7,51.4-23.5s16.9-34.3,14.5-55.1H270.5c12.4-21.6,34-26.5,50.4-19.7a38.83,38.83,0,0,1,23.5,40.6c-2,16.7-15.6,31.2-32,33.9-18.9,3.2-34.1-5.5-43.3-24.9H186.4c-8.7,57.3-66.3,90.4-117.3,76.9-45.9-12.1-75.6-58-67.9-104.6C9.9,212.7,54.1,185,90.9,184.8Z" transform="translate(0.01 0.01)"/><path d="M212.7,132.1c-23.6-1.7-38-12.7-41.7-31.3a38.1,38.1,0,0,1,19.9-41.5A39.61,39.61,0,0,1,238,67.2c13.4,14.1,14,30.1,1.5,51.5q19.2,35.4,38.5,71.2c29.3-8.3,56.9-5.2,82.3,11.6,20,13.2,33.2,31.7,39,55a92.71,92.71,0,0,1-60.1,110c-47,16.2-94-6.4-113-40.9,8.2-4.8,16.5-9.6,24.7-14.3,25.6,36.5,69.8,35.9,94.6,17.6,25.2-18.6,33.1-52.5,17.8-79.5-9.8-17.2-24.7-27.7-44.1-31.8s-37,1.2-53.6,12.2C247.8,196.9,230.2,164.5,212.7,132.1Z" transform="translate(0.01 0.01)"/></svg>';

	/**
	 * Carrier constructor
	 *
	 * @since 5.0.0
	 */
	public function __construct() {
		parent::__construct( 'webhook', __( 'Webhook', 'notification' ) );
	}

	/**
	 * Used to register Carrier form fields
	 * Uses $this->add_form_field();
	 *
	 * @return void
	 */
	public function form_fields() {

		$this->add_form_field( new Field\RecipientsField( [
			'carrier'          => 'webhook',
			'label'            => __( 'URLs', 'notification' ),
			'name'             => 'urls',
			'add_button_label' => __( 'Add URL', 'notification' ),
		] ) );

		$this->add_form_field( new Field\RepeaterField( [
			'label'            => __( 'Arguments', 'notification' ),
			'name'             => 'args',
			'add_button_label' => __( 'Add argument', 'notification' ),
			'fields'           => [
				new Field\CheckboxField(
					[
						'label'          => __( 'Hide', 'notification-slack' ),
						'name'           => 'hide',
						'checkbox_label' => __( 'Hide if empty value', 'notification' ),
					]
				),
				new Field\InputField( [
					'label'       => __( 'Key', 'notification' ),
					'name'        => 'key',
					'resolvable'  => true,
					'description' => __( 'You can use merge tags', 'notification' ),
				] ),
				new Field\InputField( [
					'label'       => __( 'Value', 'notification' ),
					'name'        => 'value',
					'resolvable'  => true,
					'description' => __( 'You can use merge tags', 'notification' ),
				] ),
			],
		] ) );

		$this->add_form_field( new Field\CheckboxField( [
			'label'          => __( 'JSON', 'notification' ),
			'name'           => 'json',
			'checkbox_label' => __( 'Send the arguments in JSON format', 'notification' ),
		] ) );

		if ( notification_get_setting( 'notifications/webhook/headers' ) ) {

			$this->add_form_field( new Field\RepeaterField( [
				'label'            => __( 'Headers', 'notification' ),
				'name'             => 'headers',
				'add_button_label' => __( 'Add header', 'notification' ),
				'fields'           => [
					new Field\CheckboxField(
						[
							'label'          => __( 'Hide', 'notification-slack' ),
							'name'           => 'hide',
							'checkbox_label' => __( 'Hide if empty value', 'notification' ),
						]
					),
					new Field\InputField( [
						'label'       => __( 'Key', 'notification' ),
						'name'        => 'key',
						'resolvable'  => true,
						'description' => __( 'You can use merge tags', 'notification' ),
					] ),
					new Field\InputField( [
						'label'       => __( 'Value', 'notification' ),
						'name'        => 'value',
						'resolvable'  => true,
						'description' => __( 'You can use merge tags', 'notification' ),
					] ),
				],
			] ) );

		}

	}

	/**
	 * Sends the notification
	 *
	 * @param  Triggerable $trigger trigger object.
	 * @return void
	 */
	public function send( Triggerable $trigger ) {

		$data = $this->data;

		$args = $this->parse_args( $data['args'] );
		$args = apply_filters_deprecated( 'notification/webhook/args', [ $args, $this, $trigger ], '6.0.0', 'notification/carrier/webhook/args' );
		$args = apply_filters( 'notification/carrier/webhook/args', $args, $this, $trigger );

		if ( $data['json'] ) {
			$args = wp_json_encode( $args );
		}

		// Headers.
		if ( $data['json'] ) {
			$headers = [ 'Content-Type' => 'application/json' ];
		} else {
			$headers = [];
		}

		if ( notification_get_setting( 'notifications/webhook/headers' ) ) {
			$headers = array_merge( $headers, $this->parse_args( $data['headers'] ) );
		}

		// Call each URL separately.
		foreach ( $data['urls'] as $url ) {
			$filtered_args = apply_filters_deprecated( 'notification/webhook/args/' . $url['type'], [ $args, $this, $trigger ], '6.0.0', 'notification/carrier/webhook/args/' . $url['type'] );
			$filtered_args = apply_filters( 'notification/carrier/webhook/args/' . $url['type'], $filtered_args, $this, $trigger );

			if ( 'get' === $url['type'] ) {
				$this->send_get( $url['recipient'], $filtered_args, $headers );
			} elseif ( 'post' === $url['type'] ) {
				$this->send_post( $url['recipient'], $filtered_args, $headers );
			}
		}

	}

	/**
	 * Sends GET request
	 *
	 * @since  5.0.0
	 * @param  string $url  URL to call.
	 * @param  array  $args    arguments.
	 * @param  array  $headers headers.
	 * @return void
	 */
	public function send_get( $url, $args = [], $headers = [] ) {

		$remote_url = add_query_arg( $args, $url );

		$remote_args = apply_filters_deprecated( 'notification/webhook/remote_args/get', [
			[
				'headers' => $headers,
			],
			$url,
			$args,
			$this,
		], '6.0.0', 'notification/carrier/webhook/remote_args/get' );

		$remote_args = apply_filters( 'notification/carrier/webhook/remote_args/get', $remote_args, $url, $args, $this );

		$response = wp_remote_get( $remote_url, $remote_args );

		do_action_deprecated( 'notification/webhook/called/get', [
			$response,
			$url,
			$args,
			$remote_args,
			$this,
		], '6.0.0', 'notification/carrier/webhook/called/get' );
		do_action( 'notification/carrier/webhook/called/get', $response, $url, $args, $remote_args, $this );

	}

	/**
	 * Sends POST request
	 *
	 * @since  5.0.0
	 * @param  string $url  URL to call.
	 * @param  array  $args    arguments.
	 * @param  array  $headers headers.
	 * @return void
	 */
	public function send_post( $url, $args = [], $headers = [] ) {

		$remote_args = apply_filters_deprecated( 'notification/webhook/remote_args/post', [
			[
				'body'    => $args,
				'headers' => $headers,
			],
			$url,
			$args,
			$this,
		], '6.0.0', 'notification/carrier/webhook/remote_args/post' );

		$remote_args = apply_filters( 'notification/carrier/webhook/remote_args/post', $remote_args, $url, $args, $this );

		$response = wp_remote_post( $url, $remote_args );

		do_action_deprecated( 'notification/webhook/called/post', [
			$response,
			$url,
			$args,
			$remote_args,
			$this,
		], '6.0.0', 'notification/carrier/webhook/called/post' );
		do_action( 'notification/carrier/webhook/called/post', $response, $url, $args, $remote_args, $this );

	}

	/**
	 * Parses args to be understand by the wp_remote_* functions
	 *
	 * @since  5.0.0
	 * @param  array $args args from saved fields.
	 * @return array       parsed args as key => value array
	 */
	private function parse_args( $args ) {

		$parsed_args = [];

		if ( empty( $args ) ) {
			return $parsed_args;
		}

		foreach ( $args as $arg ) {
			if ( isset( $arg['hide'] ) && $arg['hide'] ) {
				continue;
			}

			$parsed_args[ $arg['key'] ] = $arg['value'];
		}

		return $parsed_args;

	}

}
