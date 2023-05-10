<div class="sidebar__post-meta">
    <?php if ( $args['sidebar_heading'] || $args['sidebar_content'] ) : ?>
        <div class="sidebar__post-meta__content">
            <?php if ( $args['sidebar_heading'] ) : ?>
                <h2 class="sidebar__post-meta__heading"><?php echo esc_html( $args['sidebar_heading'] ); ?></h2>
            <?php endif; ?>
            <?php if ( $args['sidebar_content'] ) : ?>
                <div class="sidebar__post-meta__text"><?php echo wp_kses_post( wpautop( $args['sidebar_content'] )); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>