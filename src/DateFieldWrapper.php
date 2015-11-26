<?php
/**
 * @file
 * Contains \Drupal\calendar\DateFieldWrapper.
 */


namespace Drupal\calendar;


use Drupal\Core\Field\FieldItemList;

class DateFieldWrapper {


  /**
   * @var \Drupal\Core\Field\FieldItemList
   */
  protected $fieldItemList;

  /**
   * DateFieldWrapper constructor.
   */
  public function __construct(FieldItemList $fieldItemList) {
    $this->fieldItemList = $fieldItemList;
  }

  /**
   * @return \DateTime
   */
  public function getStartDate() {
    $date = new \DateTime();
    return $date->setTimestamp($this->getStartTimeStamp());
  }

  /**
   * @return \DateTime
   */
  public function getEndDate() {
    $date = new \DateTime();
    return $date->setTimestamp($this->getEndTimeStamp());
  }

  /**
   * @return int
   */
  protected function getStartTimeStamp() {
    return (int)$this->fieldItemList->getValue()[0]['value'];
  }

  /**
   * @return int
   */
  protected function getEndTimeStamp() {
    return $this->getStartTimeStamp();
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return $this->fieldItemList->isEmpty();
  }
}
