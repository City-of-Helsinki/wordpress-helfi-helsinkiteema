<div class="links-list">
    <div class="hds-container">
        <h2 class="links-list__title"><span><?php esc_html_e('You might be interested in', 'helsinki-universal'); ?></span></h2>
        <ul class="links-list__links links-list__links--title links-list__links--2">
            <li class="links-list__item">
                <div class="link">            
                    <a href="<?php esc_html_e( $args['feedback']); ?>" class="link__title_link">
                        <span><?php esc_html_e('Give feedback', 'helsinki-universal'); ?></span><?php echo helsinki_get_svg_icon('link-external', '', __('(Link leads to external service)', 'helsinki-universal')); ?>
                    </a>
                </div>
            </li>
            <li class="links-list__item">
                <div class="link">
                    <a href="<?php esc_html_e( $args['search_target']); ?>" class="link__title_link">
                        <span><?php esc_html_e('Search on hel.fi', 'helsinki-universal'); ?></span><?php echo helsinki_get_svg_icon('link-external', '', __('(Link leads to external service)', 'helsinki-universal')); ?>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>