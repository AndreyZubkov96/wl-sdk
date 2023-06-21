<?php

namespace WellnessLiving\Wl\Book\Process\Info;

use WellnessLiving\WlModelAbstract;

/**
 * An endpoint that offers functionality for the class booking wizard on the "Class and Location" page.
 *
 * @deprecated Use {@link \Wellnessliving\Wl\Book\Process\Info\Info54Model} instead.
 */
class InfoModel extends WlModelAbstract
{
  /**
   * Week days available for recurring booking. Constants of {@link \WellnessLiving\Core\a\ADateWeekSid} class.
   *
   * `null` if recurring booking is not available.
   *
   * @get result
   * @var int[]|null
   */
  public $a_day_available;

  /**
   * The keys of users' activity.
   *
   * @post result
   * @var string[]
   */
  public $a_login_activity;

  /**
   * Information about recurring booking:
   * <dl>
   *   <dt>
   *     int[] [<var>a_week</var>]
   *   </dt>
   *   <dd>
   *     Days of week when appointment must repeat. Constants of {@link \WellnessLiving\Core\a\ADateWeekSid} class.
   *     Empty if appointment must not repeat weekly.
   *   </dd>
   *   <dt>
   *     string [<var>dl_end</var>]
   *   </dt>
   *   <dd>
   *     Date when appointment repeat must stop. Empty if repeat must not stop at a certain date.
   *   </dd>
   *   <dt>
   *     int [<var>i_occurrence</var>]
   *   </dt>
   *   <dd>
   *     Number of occurrences after that appointment repeat must stop.
   *     Empty if repeat must not stop after a certain number of occurrences.
   *   </dd>
   *   <dt>
   *     int <var>i_period</var>
   *   </dt>
   *   <dd>
   *     Frequency of appointment repeating.
   *   </dd>
   *   <dt>
   *     int <var>id_period</var>
   *   </dt>
   *   <dd>
   *     Measurement unit of `i_period`. One of {@link \WellnessLiving\Core\a\ADurationSid} constants.
   *   </dd>
   *   <dt>
   *     bool [<var>is_month</var>]
   *   </dt>
   *   <dd>
   *     `true` if appointment must repeat monthly at the same date.
   *     `false` if appointment must repeat monthly at the same week day.
   *     `null` if appointment must not repeat monthly.
   *   </dd>
   * </dl>
   *
   * `null` if booking must be not recurring.
   *
   * @post post
   * @var array|null
   */
  public $a_repeat;

  /**
   * A list of assets being booked. Every element has the next structure:
   * <dl>
   *   <dt>int <var>i_index</var></dt>
   *   <dd>Order number of the asset (maybe from 1 to asset quantity).</dd>
   *   <dt>string <var>k_resource</var></dt>
   *   <dd>The key of asset.</dd>
   * </dl>
   *
   * @post post
   * @var array[]
   */
  public $a_resource = [];

  /**
   * A list of all class sessions that can be booked together. Every element has the next structure:
   * <dl>
   *   <dt>
   *     string[] <var>a_staff</var>
   *   </dt>
   *   <dd>
   *     List of staff names that are leading this session.
   *   </dd>
   *   <dt>
   *     string[] <var>a_virtual_location</var>
   *   </dt>
   *   <dd>
   *     List of virtual locations.
   *   </dd>
   *   <dt>
   *     string <var>dt_date</var>
   *   </dt>
   *   <dd>
   *     The date/time when session starts in MySQL format and in GMT.
   *   </dd>
   *   <dt>
   *     boolean <var>is_select</var>
   *   </dt>
   *   <dd>
   *     <tt>true</tt> if this session should be selected when page is initialized;
   *     <tt>false</tt> if otherwise.
   *   </dd>
   *   <dt>
   *     bool <var>is_wait</var>
   *   </dt>
   *   <dd>
   *     `true` if client is added to a wait list, `false` - to an active list.
   *   </dd>
   *   <dt>
   *     bool <var>is_wait_list_unpaid</var>
   *   </dt>
   *   <dd>
   *     Allow clients to join the wait list unpaid.
   *   </dd>
   *   <dt>
   *     string <var>k_class_period</var>
   *   </dt>
   *   <dd>
   *     The key of the session.
   *   </dd>
   *   <dt>
   *     string <var>k_location</var>
   *   </dt>
   *   <dd>
   *     Location key.
   *   </dd>
   *   <dt>
   *     bool <var>m_price</var>
   *   </dt>
   *   <dd>
   *     Price of the session.
   *   </dd>
   *   <dt>
   *     string <var>s_location</var>
   *   </dt>
   *   <dd>
   *     The name of the location where the session occurred.
   *   </dd>
   *   <dt>
   *     string <var>s_start</var>
   *   </dt>
   *   <dd>
   *     The date/time when the session starts in human-readable format.
   *     Returned in the time zone of the location.
   *   </dd>
   *   <dt>
   *     string <var>text_duration</var>
   *   </dt>
   *   <dd>
   *     String representation of session duration.
   *     Duration formatting method {@link \Wellnessliving\Wl\Book\Process\Info\InfoModel::_classDurationFormat()}.
   *   </dd>
   * </dl>
   *
   * @get result
   * @var array[]
   */
  public $a_session_all;

  /**
   * The selected sessions.
   *
   * <b>Keys</b> - The class period keys.
   * <b>Values</b> - List of date/time when the session occurred in MySQL format and in GMT.
   *
   * @post post
   * @var array
   */
  public $a_session_select = [];

  /**
   * Selected sessions on the waiting list without pay.
   *
   * Keys - session IDs.
   *
   * Values - index arrays of dates/time when session is occurred. In MySQL format. In GMT.
   *
   * @post post
   * @var array
   */
  public $a_session_wait_list_unpaid = [];

  /**
   * The staff member conducting the session. Every element has the next structure:
   * <dl>
   *   <dt>
   *     array <var>a_logo</var>
   *   </dt>
   *     <dd>
   *     The staff member photo:
   *     <dl>
   *       <dt>int <var>i_height</var></dt>
   *       <dd>The image height.</dd>
   *       <dt>int <var>i_width</var></dt>
   *       <dd>The image width.</dd>
   *       <dt>string <var>s_url</var></dt>
   *       <dd>The image URL.</dd>
   *     </dl>
   *   </dd>
   *   <dt>string <var>s_family</var></dt>
   *   <dd>The first letter of staff member surname.</dd>
   *   <dt>string <var>s_staff</var></dt>
   *   <dd>The staff member's name.</dd>
   *   <dt>string <var>uid</var></dt>
   *   <dd>UID of the staff member.</dd>
   * </dl>
   *
   * @get result
   * @var array[]
   */
  public $a_staff;

  /**
   * The keys of the bookings made.
   *
   * @post result
   * @var string[]
   */
  public $a_visit;

  /**
   * Whether the class/event can be booked at this step or not.
   * External process control flag.
   *
   * @post post
   * @var bool
   */
  public $can_book = true;

  /**
   * Date when this class session occurrences stop.
   *
   * @get result
   * @var string
   */
  public $dl_end;

  /**
   * Date/time to which session is booked.
   *
   * @get get
   * @post get
   * @var string
   */
  public $dt_date_gmt = '';

  /**
   * The date/time of the session the user is booking in MySQL format in the location's timezone.
   *
   * @get result
   * @var string
   */
  public $dt_date_local;

  /**
   * `true` if price for the individual session should be hidden, if client has applicable pricing option to pay for this
   * booking.
   * `false` if price should be shown always.
   *
   * @get result
   * @var bool
   */
  public $hide_price;

  /**
   * The text of the contract to which the user must agree before book this session.
   * Not empty if business has contract and if user did not agree to this contract.
   *
   * @get result
   * @var string
   */
  public $html_contract;

  /**
   * Class duration in human-readable format.
   *
   * @get result
   * @var string
   */
  public $html_duration;

  /**
   * The special instructions for the class.
   *
   * @get result
   * @var string
   */
  public $html_special;

  /**
   * Special instructions preview for class.
   *
   * @get result
   * @var string
   */
  public $html_special_preview;

  /**
   * Number of available spots.
   *
   * `null` if this information is not available.
   *
   * @get result
   * @var int|null
   */
  public $i_available;

  /**
   * Number of booked spots.
   *
   * `null` if this information is not available.
   *
   * @get result
   * @var int|null
   */
  public $i_book;

  /**
   * The duration of the session in minutes.
   *
   * @get result
   * @var int
   */
  public $i_duration;

  /**
   * Estimated place of reservation on the waiting list.
   *
   * @get result
   * @var int
   */
  public $i_wait_spot = 0;

  /**
   * Mode type. One of {@link \Wellnessliving\Wl\Mode\ModeSid} constants.
   *
   * @get get
   * @post get
   * @var int
   */
  public $id_mode = 0;

  /**
   * Determines if the user has agreed to the liability release.
   * `true` - if  the user has agreed. Otherwise, this will be.
   * `false` - if the user hasn't agreed or the agreement isn't required.
   *
   * @post post
   * @var bool
   */
  public $is_agree = false;

  /**
   * `true` if recurring booking is available, `false` otherwise.
   *
   * @get result
   * @var bool
   */
  public $is_book_repeat_client;

  /**
   * If client must authorize credit card.
   *
   * @post result
   * @var bool
   */
  public $is_card_authorize = false;

  /**
   * Can the class/event be booked immediately or not.
   *
   * The verification is based on the search for client's promotions and other features of the class/event.
   * But it does not take into account the presence of other mandatory steps.
   * Their presence will be indicated by the {@link \Wellnessliving\Wl\Book\Process\Info\InfoModel::$is_next} flag.
   *
   * @post result
   * @var bool
   */
  public $is_force_book = false;

  /**
   * `true` if user pressed 'Pay later'.
   * `false` if user pressed 'Pay now'.
   *
   * @post post
   * @var bool
   */
  public $is_force_pay_later = false;

  /**
   * `true` - next steps of the wizard are needed (for example, to purchase something to book the selected session).
   * `false` - no need for next steps (all that's needed has already been purchased).
   *
   * @post result
   * @var bool
   */
  public $is_next;

  /**
   * `true` if event can be paid with pricing option only.
   * `false` if full event purchase or single session purchase are allowed.
   *
   * Copy of {@link \RsClassSql}.<tt>is_promotion_only</tt>.
   *
   * @get result
   * @var bool
   */
  public $is_promotion_only;

  /**
   * Whether the class can be paid with single session.
   *
   * @get result
   * @var bool
   */
  public $is_single_buy;

  /**
   * Whether the full text of the special instructions fits within the preview length or not.
   *
   * @get result
   * @var bool
   */
  public $is_special_preview = false;

  /**
   * `true` if class is virtual, `false` otherwise.
   *
   * @get result
   * @var bool
   */
  public $is_virtual;

  /**
   * Key of session which is booked.
   *
   * @get get
   * @post get
   * @var string
   */
  public $k_class_period = '0';

  /**
   * Class period location key.
   *
   * @get result
   * @var string
   */
  public $k_location;

  /**
   * Login promotion to be used to book a class.
   *
   * Primary key from {@link  \RsLoginProductSql}.
   *
   * @post post
   * @var string
   */
  public $k_login_promotion = '';

  /**
   * Session pass to be used to book a class.
   *
   * Primary key from {@link  \Wl\Session\Pass\Sql}.
   *
   * @post post
   * @var string
   */
  public $k_session_pass = '';

  /**
   * Price of the session.
   *
   * @get result
   * @var string
   */
  public $m_price;

  /**
   * Whole event cost.
   *
   * @get result
   * @var string
   */
  public $m_price_total;

  /**
   * Event price at an early discount.
   *
   * An empty string if there is no discount.
   *
   * @get result
   * @var string
   */
  public $m_price_total_early;

  /**
   * The class title.
   *
   * @get result
   * @var string
   */
  public $s_class;

  /**
   * The location address.
   *
   * @get result
   * @var string
   */
  public $s_location_address;

  /**
   * The location title.
   *
   * @get result
   * @var string
   */
  public $s_location_title;

  /**
   * User signature.
   *
   * @post post
   * @var string
   */
  public $s_signature = '';

  /**
   * The time when the session takes place in the location's time zone. In format `hh:mm`.
   *
   * @get result
   * @var string
   */
  public $s_time;

  /**
   * Room where session takes place.
   *
   * @get result
   * @var string
   */
  public $text_room;

  /**
   * Text representation of the list of staffs.
   * List of staff see {@link \Wellnessliving\Wl\Book\Process\Info\InfoModel::$a_staff}.
   *
   * @get result
   * @var string
   */
  public $text_staff;

  /**
   * Timezone abbreviation.
   *
   * @get result
   * @var string
   */
  public $text_timezone;

  /**
   * Key of a user who is making a book.
   *
   * @get get
   * @post get
   * @var string
   */
  public $uid = '0';
}

?>