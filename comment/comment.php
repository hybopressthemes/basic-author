<li <?php hybrid_attr( 'comment' ); ?>>

    <article>
        <header class="comment-info clearfix">
			<?php echo get_avatar( $comment, 40 ); ?>
			<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite><br />
        </header><!-- .comment-meta -->

		<div <?php hybrid_attr( 'comment-content' ); ?>>
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'hybopress' ); ?></em>
				</p>
			<?php endif; ?>
			<?php comment_text(); ?>
        </div><!-- .comment-content -->

		<footer class="comment-meta clearfix">
			<div class="pull-left comment-meta-left">
				<?php hybrid_comment_reply_link(); ?>
			</div>
			<div class="pull-right comment-meta-right">
				<a <?php hybrid_attr( 'comment-permalink' ); ?>><time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%1$s at %2$s', 'hybopress' ), get_comment_date(), get_comment_time() ); ?></time></a>
				<?php edit_comment_link(); ?>
			</div>
		</footer>
    </article>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
