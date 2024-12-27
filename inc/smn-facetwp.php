<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function fwp_add_facet_labels() {
    if ( !function_exists( 'facetwp_display' ) ) return false;
  ?>
    <script>
      (function($) {
        $(document).on('facetwp-loaded', function() {
          $('.facetwp-facet').each(function() {
            var facet = $(this);
            var facet_name = facet.attr('data-name');
            var facet_type = facet.attr('data-type');
            var facet_label = FWP.settings.labels[facet_name];
            if (facet_type !== 'pager' && facet_type !== 'sort' && facet_type !== 'search' && facet_type !== 'reset') {
              if (facet.closest('.facet-wrap').length < 1 && facet.closest('.facetwp-flyout').length < 1) {
                facet.wrap('<div class="facet-wrap"></div>');
                facet.before('<label class="facet-label">' + facet_label + '</label>');
              }
            }
          });
        });
      })(jQuery);
    </script>
  <?php
}
add_action( 'wp_head', 'fwp_add_facet_labels', 100 );

add_action( 'wp_head', function() { ?>

  <script>
      (function($) {
          $(document).on('facetwp-refresh', function() {
              if ( FWP.soft_refresh == true ) {
                  FWP.enable_scroll = true;
              } else {
                  FWP.enable_scroll = false;
              }
          });
          $(document).on('facetwp-loaded', function() {
              if ( FWP.enable_scroll == true ) {
                  $('html, body').animate({ scrollTop: 0 }, 500);
              }
          });
      })(jQuery);
  </script>

<?php } );

add_action( 'wp_head', function() {
    ?>
      <script>
        (function($) {
          $(function() {
            if ('object' != typeof FWP) return;
   
            /* Modify each facet's wrapper HTML */
            FWP.hooks.addFilter('facetwp/flyout/facet_html', function(facet_html) {
              return facet_html.replace('<h3>{label}</h3>', '<label>{label}</label>');
            });
          });
        })(jQuery);
      </script>
    <?php
  }, 100 );

  add_action( 'wp_footer', function() {
    ?>
      <script>
        (function($) {
          document.addEventListener('facetwp-loaded', function() {
            $.each(FWP.settings.num_choices, function(key, val) {
   
              // assuming each facet is wrapped within a "facet-wrap" container element
              // this may need to change depending on your setup, for example:
              // change ".facet-wrap" to ".widget" if using WP text widgets
   
              var $facet = $('.facetwp-facet-' + key);
              var $wrap = $facet.closest('.facet-wrap');
              var $flyout = $facet.closest('.flyout-row');
              if ($wrap.length || $flyout.length) {
                var $which = $wrap.length ? $wrap : $flyout;
                (0 === val) ? $which.hide() : $which.show();
              }
            });
          });
        })(jQuery);
      </script>
    <?php
  }, 100 );


// Add a spinning loading icon and fade the listing template
add_action( 'facetwp_scripts', function() {
  ?>
  <script>
    (function($) {
 
      // Insert loading icon before the listing template
      $(document).ready(function() {
        $('.facetwp-template').wrap('<div class="facetwp-template-wrapper position-relative"></div>');
        $('<div class="facetwp-loading-icon"><div class="spinner-grow" role="status"><span class="visually-hidden"><?php echo __( 'Loading…', 'epicpower' ); ?></span></div></div>').insertBefore('.facetwp-template');
      });
 
      // On start of the facet refresh, but not on first page load
      $(document).on('facetwp-refresh', function() {
        if ( FWP.loaded ) {
          $('.facetwp-template, .facetwp-loading-icon').addClass('loading');
        }
      });
 
      // On finishing the facet refresh
      $(document).on('facetwp-loaded', function() {
        $('.facetwp-template, .facetwp-loading-icon').removeClass('loading');
      });
 
    })(jQuery);
  </script>
 
  <style>
 
    .facetwp-loading-icon {
      opacity: 0;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  
    /* Fade in/out of the loading icon */
    .facetwp-loading-icon.loading {
      opacity: 1;
      transition: opacity .2s ease-out;
    }
 
    /* Fade in/out of the whole listing template */
    .facetwp-template {
      opacity: 1;
      transition: opacity 0.1s ease-out;
    }
    .facetwp-template.loading {
      opacity: 0.2;
    }
 
  </style>
  <?php
}, 100 );