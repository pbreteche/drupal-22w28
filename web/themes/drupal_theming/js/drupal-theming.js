/**
 * @file
 * Formation Drupal Theming behaviors.
 */
(function (Drupal, $) {

  'use strict';

  Drupal.behaviors.drupalTheming = {
    attach: function (context, settings) {
      console.log(context);
      once('collapsible', '.node--view-mode-teaser', context).forEach((element => {
        element.querySelector('.trigger-collapse').addEventListener('click', () => {
          element.classList.toggle('collapsed');
        })
      }))
    }
  };

} (Drupal, jQuery));
