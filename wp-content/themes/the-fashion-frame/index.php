<?php
/**
 * The main template file
 *
 * @package The_Fashion_Frame
 */

get_header();
?>

<div class="site-container" style="padding-top: var(--section-gap-sm); padding-bottom: var(--section-gap-lg);">
	<?php if ( have_posts() ) : ?>

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header" style="margin-bottom: 3rem; text-align: center;">
				<h1 class="font-headline-lg"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

		<div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.5rem;">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'category-card' ); ?> style="aspect-ratio: auto; min-height: 380px; padding: 2rem; background: var(--color-surface-container-low); display: flex; flex-direction: column; justify-content: space-between;">
					<div>
						<h2 class="font-headline-sm" style="margin-bottom: 0.75rem;">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="font-body-md" style="color: var(--color-on-surface-variant);">
							<?php the_excerpt(); ?>
						</div>
					</div>
					<a href="<?php the_permalink(); ?>" class="font-label-caps" style="color: var(--color-secondary); margin-top: 1.5rem; display: inline-block;">
						<?php esc_html_e( 'READ MORE', 'the-fashion-frame' ); ?> &rarr;
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<div class="pagination-wrapper" style="margin-top: 3rem; text-align: center;">
			<?php the_posts_pagination(); ?>
		</div>

	<?php else : ?>

		<div class="no-results" style="text-align: center; padding: 4rem 0;">
			<h2 class="font-headline-md"><?php esc_html_e( 'Nothing Found', 'the-fashion-frame' ); ?></h2>
			<p class="font-body-md" style="margin-top: 1rem;"><?php esc_html_e( 'It seems we cannot find what you are looking for.', 'the-fashion-frame' ); ?></p>
		</div>

	<?php endif; ?>
</div>

<?php
get_footer();
