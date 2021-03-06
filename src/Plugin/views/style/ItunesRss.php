<?php

namespace Drupal\itunes_rss\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\Rss;

/**
 * Default style plugin to render an RSS feed.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "itunes_rss",
 *   title = @Translation("iTunes RSS Feed"),
 *   help = @Translation("Generates an iTunes RSS feed from a view."),
 *   theme = "views_view_itunes_rss",
 *   display_types = {"feed"}
 * )
 */
class ItunesRss extends Rss {

  /**
   * Get a list of all itunes:* fields that apply to the <channel> element.
   *
   * @return array
   *   A flat array of field names.
   *
   * @see https://help.apple.com/itc/podcasts_connect/#/itcb54353390
   */
  public function getItunesChannelFields() {
    $fields = [
      'type',
      'name',
      'email',
      'author',
      'subtitle',
      'summary',
      'explicit',
      'copyright',
      'block',
      'complete',
      'image',
      'new-feed-url',
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['podcastFrontpage'] = ['default' => ''];
    $options['image'] = ['default' => ''];
    $options['author'] = ['default' => ''];
    $options['name'] = ['default' => ''];
    $options['email'] = ['default' => ''];
    $options['category'] = ['default' => ''];
    $options['sub_category'] = ['default' => ''];
    $options['explicit'] = ['default' => ''];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['help']['#markup'] = $this->t(
      'See @link for detailed information on available iTunes tags.',
      ['@link' => 'https://help.apple.com/itc/podcasts_connect/#/itcb54353390']
    );
    $form['podcastFrontpage'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url of the Podcast Frontpage'),
      '#default_value' => $this->options['podcastFrontpage'],
      '#description' => $this->t('This will appear in the RSS feed channel section.'),
      '#maxlength' => 1024,
    ];
    $form['image'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RSS image URL.'),
      '#default_value' => $this->options['image'],
      '#description' => $this->t('This will appear in the RSS feed channel section. Max and Best size: 3000px * 3000px.'),
      '#maxlength' => 1024,
    ];
    $form['author'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Author name.'),
      '#default_value' => $this->options['author'],
      '#description' => $this->t('This will appear in the RSS feed channel section. The group responsible for creating the show. Show author most often refers to the parent company or network of a podcast, but it can also be used to identify the host(s) if none exists.'),
      '#maxlength' => 1024,
    ];
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Owner name.'),
      '#default_value' => $this->options['name'],
      '#description' => $this->t('This will appear in the RSS feed channel section.'),
      '#maxlength' => 1024,
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Owner email.'),
      '#default_value' => $this->options['email'],
      '#description' => $this->t('This will appear in the RSS feed channel section.'),
      '#maxlength' => 1024,
    ];
    $form['category'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Category'),
      '#default_value' => $this->options['category'],
      '#description' => $this->t('This will appear in the RSS feed channel section. Valid Categories: https://help.apple.com/itc/podcasts_connect/#/itc9267a2f12'),
      '#maxlength' => 1024,
    ];
    $form['sub_category'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sub Category'),
      '#default_value' => $this->options['sub_category'],
      '#description' => $this->t('This will appear in the RSS feed channel section.'),
      '#maxlength' => 1024,
    ];
    $form['explicit'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Explicit'),
      '#default_value' => $this->options['explicit'],
      '#description' => $this->t('This will appear in the RSS feed channel section.'),
    ];
  }

  /**
   * Get RSS feed image.
   *
   * @return string
   *   The string containing the image URL.
   */
  public function getImage() {
    $image = $this->options['image'];

    return $image;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $this->namespaces = [
      'xmlns:itunes' => 'http://www.itunes.com/dtds/podcast-1.0.dtd',
      'xmlns:dc' => 'http://purl.org/dc/elements/1.1/',
      'xmlns:atom' => 'http://www.w3.org/2005/Atom',
    ];

    return $build;
  }

}
