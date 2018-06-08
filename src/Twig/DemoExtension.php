<?php

namespace Drupal\twig_ext_demo\Twig;

use Drupal\Core\Datetime\DateFormatterInterface;
use Twig_Extension;

/**
 * Twig extension demo.
 */
class DemoExtension extends Twig_Extension {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * DemoExtension constructor.
   *
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   The date formatter service.
   */
  public function __construct(DateFormatterInterface $dateFormatter) {
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      new \Twig_SimpleFilter('countdown', [$this, 'renderCountdown']),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('countdown', [$this, 'renderCountdown']),
    ];
  }

  /**
   * Renders the countdown time.
   *
   * @param string $end
   *   The end time.
   * @param string|null $start
   *   Optional. Start time, defaults to current time.
   *
   * @return array
   *   The rendered countdown time.
   */
  public function renderCountdown($end, $start = NULL) {
    if ($start === NULL) {
      $start = REQUEST_TIME;
    }
    else {
      $start = strtotime($start);
    }

    return [
      '#markup' => $this->dateFormatter->formatDiff($start, strtotime($end)),
      '#cache' => ['max-age' => 0],
    ];
  }

}
