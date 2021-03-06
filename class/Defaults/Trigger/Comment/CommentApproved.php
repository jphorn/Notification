<?php
/**
 * Comment approved trigger
 *
 * @package notification
 */

namespace BracketSpace\Notification\Defaults\Trigger\Comment;

use BracketSpace\Notification\Defaults\MergeTag;

/**
 * Comment added trigger class
 */
class CommentApproved extends CommentTrigger {

	/**
	 * Constructor
	 *
	 * @param string $comment_type optional, default: comment.
	 */
	public function __construct( $comment_type = 'comment' ) {

		parent::__construct( [
			'slug'         => 'wordpress/comment_' . $comment_type . '_approved',
			// Translators: %s comment type.
			'name'         => sprintf( __( '%s approved', 'notification' ), ucfirst( $comment_type ) ),
			'comment_type' => $comment_type,
		] );

		$this->add_action( 'transition_comment_status', 10, 3 );

		// translators: comment type.
		$this->set_description( sprintf( __( 'Fires when %s is approved', 'notification' ), __( ucfirst( $comment_type ), 'notification' ) ) );

	}

	/**
	 * Assigns action callback args to object
	 *
	 * @param string $comment_new_status New comment status.
	 * @param string $comment_old_status Old comment status.
	 * @param object $comment            Comment object.
	 * @return mixed void or false if no notifications should be sent
	 */
	public function action( $comment_new_status, $comment_old_status, $comment ) {

		$this->comment = $comment;

		if ( 'spam' === $this->comment->comment_approved && notification_get_setting( 'triggers/comment/akismet' ) ) {
			return false;
		}

		if ( ! $this->is_correct_type( $this->comment ) ) {
			return false;
		}

		if ( $comment_new_status === $comment_old_status || 'approved' !== $comment_new_status ) {
			return false;
		}

		parent::assign_properties();

	}

}
