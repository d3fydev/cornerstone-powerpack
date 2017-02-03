<?php

$Elements = Cornerstone_Powerpack_Elements::getInstance();

// Register custom Cornerstone elements: alias, name, description

// Responsive Slider
$Elements->register(
  'responsive-slider',
  'Responsive Slider',
  'Responsive slider with text and content sizing relative to the window width, resulting in consistent layout regardless of screen size.'
);
$Elements->set_option('responsive-slider', 'video_url', 'https://www.youtube.com/embed/vjqg0DxEK0E');

// Team Members
$Elements->register(
  'team-members',
  'Team Members',
  'Adds a Team Member element to the Cornerstone Page Builder in WordPress. Displays photo of team member with a Modal pop-up when clicked on which shows additional information.'
);

// Carousel
$Elements->register(
  'carousel',
  'Carousel',
  'A carousel element for the Cornerstone Page Builder in WordPress.'
);

// Advanced Button
$Elements->register(
  'button-advanced',
  'Advanced Button',
  'Advanced button element.'
);

// Modal
$Elements->register(
  'modal',
  'Modal',
  'A modal popup box for Cornerstone.'
);

// Image Overlay
$Elements->register(
  'image-overlay',
  'Image Overlay',
  'Image Overlay element.'
);
