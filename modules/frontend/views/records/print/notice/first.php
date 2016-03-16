<?php
/**
 * @var $record \app\models\Record
 * @var $owner \app\models\Owner
 * @var $citation \app\models\base\Citation
 * @var $vehicle \app\models\base\Vehicle
 * @var $public_host string
 */
?>

<div id="jpedal" style="overflow: hidden; position: relative; width: 825px; height: 1100px;">

    <!-- Begin text definitions (Positioned/styled in CSS) -->

    <div id="t1_1" class="t s1_1">JONES COUNTY, GEORGIA</div>
    <div id="t2_1" class="t s2_1">TRAFFIC CITATION FOR STOPARM VIOLATION</div>
    <div id="t3_1" class="t s3_1">NCIC Number</div>
    <div id="t4_1" class="t s4_1">SS NR-GA0840000</div>
    <div id="t5_1" class="t s3_1"><?= Yii::t('app', 'Citation Number') ?></div>
    <div id="t6_1" class="t s4_1"><?= $citation->citation_number ?></div>

    <!-- registered owner-->

    <div id="ti_1" class="t m2_1 s4_1"><?= Yii::t('app', 'REGISTERED OWNER') ?></div>

    <div id="te_1" class="t s9_1"><?= Yii::t('app', 'FIRST NOTICE') ?></div>
    <div id="t7_1" class="t s4_1"><?= $owner->getFullName() ?></div>
    <div id="t8_1" class="t s5_1"><?= $owner->address_1 ?></div>
    <div id="t9_1" class="t s5_1"><?= $owner->city ?> <?= $owner->zip_code ?></div>

    <!-- violation details-->

    <div id="tj_1" class="t m2_1 s4_1"><?= Yii::t('app', 'VIOLATION DETAILS') ?></div>

    <div id="tb_1" class="t s7_1"><?= Yii::t('app', 'Citation Number') ?></div>
    <div id="tc_1" class="t s7_1">:</div>
    <div id="td_1" class="t s8_1"><?= $citation->citation_number ?></div>
    <div id="t19_1" class="t s7_1"><?= Yii::t('app', 'Notice Date') ?></div>
    <div id="t1a_1" class="t s7_1">:</div>
    <div id="t1b_1" class="t s8_1"><?= date('d M Y', $citation->created_at) ?></div>
    <div id="t1c_1" class="t s7_1"><?= Yii::t('app', 'Plate/State') ?></div>
    <div id="t1d_1" class="t s7_1">:</div>
    <div id="t1e_1" class="t s8_1"><?= join(' / ', [$vehicle->tag, $vehicle->state]) ?></div>
    <div id="t1f_1" class="t s7_1"><?= Yii::t('app', 'Make/Model/Year :') ?></div>
    <div id="t1g_1" class="t s8_1"><?= join(' / ', [$vehicle->make, $vehicle->model, $vehicle->year]) ?></div>
    <div id="t1h_1" class="t s7_1"><?= Yii::t('app', 'Viol. Date/Time') ?></div>
    <div id="t1i_1" class="t s7_1">:</div>
    <div id="t1j_1" class="t s8_1"><?= date('d M Y / h:i A', $record->infraction_date) ?></div>
    <div id="t1k_1" class="t s7_1"><?= Yii::t('app', 'Viol. Location') ?></div>
    <div id="t1l_1" class="t s7_1">:</div>
    <div id="t1m_1" class="t s8_1">1628 N OAKSHOT ST</div>
    <div id="t1v_1" class="t s7_1"><?= Yii::t('app', 'Viol. Nature') ?></div>
    <div id="t1w_1" class="t s7_1">:</div>
    <div id="t1x_1" class="t s8_1">VEHICLE WAS OPERATED IN</div>
    <div id="t1y_1" class="t s8_1">DISREGARD OR DISOBEDIENCE</div>
    <div id="t1z_1" class="t s8_1">OF O.C.G.A.</div>
    <div id="t20_1" class="t s15_1">§</div>
    <div id="t21_1" class="t s8_1">40-6-163 (2014)</div>
    <div id="t22_1" class="t s8_1">SUBSECTION (A)</div>

    <div id="t23_1" class="t s16_1"><?= Yii::t('app', 'TOTAL AMOUNT DUE:') ?></div>
    <div id="t24_1" class="t s17_1"><?= $citation->getTotalPayment(true) ?></div>
    <div id="t25_1" class="t s18_1">YOU MUST REMIT PAYMENT OF THE</div>
    <div id="t26_1" class="t s18_1">APPLICABLE FINE OR REQUEST A</div>
    <div id="t27_1" class="t s18_1">COURT DATE TO CONTEST THIS</div>
    <div id="t28_1" class="t s18_1">ALLEGED VIOLATION BY THE DATE</div>
    <div id="t29_1" class="t s18_1">SHOWN BELOW.</div>
    <div id="t2a_1" class="t s16_1"><?= Yii::t('app', 'PAY BY / CONTEST BY:') ?></div>
    <div id="t2b_1" class="t s19_1"><?= date('d M Y', $citation->expired_at) ?></div>

    <!-- SUMMONS-->

    <div id="t10_1" class="t m2_1 s4_1"><?= Yii::t('app', 'SUMMONS') ?></div>

    <div id="tk_1" class="t s3_1">This citation shall constitute official notice to you that the vehicle shown in this photographic record</div>
    <div id="tl_1" class="t s3_1">was operated in disregard or disobedience of subsection (a) of this Code section O.C.G.A. § 40-6-163</div>
    <div id="tm_1" class="t s3_1">(see overleaf), proof of which is evidenced by these recorded images.</div>
    <div id="tn_1" class="t s3_1">These recorded images have been reviewed and approved by a certified peace officer employed by a</div>
    <div id="to_1" class="t s3_1">law enforcement agency authorized to enforce this Code section O.C.G.A. § 40-6-163, and based upon</div>
    <div id="tp_1" class="t s3_1">inspection of recorded images, the owner’s motor vehicle was found to have been operated in</div>
    <div id="tq_1" class="t s3_1">disregard or disobedience of subsection (a) of this Code section O.C.G.A. § 40-6-163 and that such</div>
    <div id="tr_1" class="t s3_1">disregard or disobedience was not otherwise authorized by law.</div>
    <div id="ts_1" class="t s3_1">Please note that the registrant of the motor vehicle is legally responsible for this violation (see overleaf</div>
    <div id="tt_1" class="t s3_1">- subsection (d)(3)(D) of this Code section O.C.G.A. § 40-6-163). If you are not the driver of the vehicle</div>
    <div id="tu_1" class="t s3_1">at the time of the alleged violation, you may request a court date to contest this alleged violation (see</div>
    <div id="tv_1" class="t s3_1">overleaf - subsection (d)(3)(D) parts (i) and (ii) of this Code section O.C.G.A. § 40-6-163).</div>
    <div id="tw_1" class="t s3_1">If you do not make payment, or request a court date, by the deadline noted on this citation, as per</div>
    <div id="tx_1" class="t s3_1">subsection (d)(5) of this Code section O.C.G.A. § 40-6-163 (see overleaf), you shall be deemed to have</div>
    <div id="ty_1" class="t s3_1">waived any and all rights to contest the alleged violation and shall become immediately liable for the</div>
    <div id="tz_1" class="t s3_1">civil monetary penalty as stated in this citation.</div>


    <div id="t11_1" class="t s12_1"><?= Yii::t('app', 'Reviewed and Confirmed by:') ?></div>
    <div id="t12_1" class="t s12_1"><?= Yii::t('app', 'Officer') ?></div>
    <div id="t13_1" class="t s12_1">:</div>
    <div id="t14_1" class="t s12_1">Holly Hunter</div>
    <div id="t15_1" class="t s12_1"><?= Yii::t('app', 'Badge Number') ?></div>
    <div id="t16_1" class="t s12_1">:</div>
    <div id="t17_1" class="t s12_1">JCPD 4080</div>
    <div id="t18_1" class="t s12_1"><?= Yii::t('app', 'Jones County, Georgia') ?></div>

    <div id="ta_1" class="t m1_1 s6_1"></div>
    <div id="t1o_1" class="t s13_1"><?= Yii::t('app', 'ENCLOSE STUB WHEN RETURNING') ?></div>
    <div id="t1p_1" class="t s13_1">•</div>
    <div id="t1q_1" class="t s13_1"><?= Yii::t('app', 'ALLOW 5 DAYS FOR DELIVERY') ?></div>
    <div id="t1r_1" class="t s14_1">•</div>
    <div id="t1s_1" class="t s13_1"><?= Yii::t('app', 'DO NOT SEND CASH') ?></div>
    <div id="t1t_1" class="t s14_1">•</div>
    <div id="t1u_1" class="t s13_1"><?= Yii::t('app', 'DO NOT STAPLE CHECK TO THIS FORM') ?></div>

    <!-- response stub-->

    <div id="t1n_1" class="t m2_1 s4_1"><?= Yii::t('app', 'RESPONSE STUB') ?></div>

    <div id="t2f_1" class="t s4_1"><?= Yii::t('app', 'MAKE ALL CHEQUES PAYABLE TO:') ?></div>
    <div id="t2c_1" class="t s4_1"><?= Yii::t('app', 'RS TICKET PROCESSING SERVICES') ?></div>
    <div id="t2d_1" class="t s5_1"><?= Yii::t('app', '446 HARRISON STREET') ?></div>
    <div id="t2e_1" class="t s5_1"><?= Yii::t('app', 'SUMAS WA 98295') ?></div>

    <div id="t2s_1" class="t s3_1"><?= Yii::t('app', 'View the violation, pay your ticket, or request a court date online at') ?></div>
    <div id="t2u_1" class="t s3_1"><?= $public_host ?></div>

    <div id="t2v_1" class="t s7_1"><?= Yii::t('app', 'Location Code:') ?></div>
    <div id="t2w_1" class="t s8_1"><?= $citation->location_code ?></div>
    <div id="t2q_1" class="t s7_1"><?= Yii::t('app', 'Citation Number:') ?></div>
    <div id="t2r_1" class="t s8_1"><?= $citation->citation_number ?></div>
    <div id="t2i_1" class="t s7_1"><?= Yii::t('app', 'Unique Passcode:') ?></div>
    <div id="t2j_1" class="t s8_1"><?= $citation->unique_passcode ?></div>

    <div id="t2x_1" class="t s3_1"><?= Yii::t('app', 'Violation Penalty:') ?></div>
    <div id="t2y_1" class="t s3_1"><?= $citation->penalty ?></div>
    <div id="t2z_1" class="t s3_1"><?= Yii::t('app', 'Processing Fee ({fee}%):', ['fee' => $citation->fee]) ?></div>
    <div id="t30_1" class="t s3_1"><?= $citation->getProcessingFee() ?></div>
    <div id="t2g_1" class="t s12_1"><?= Yii::t('app', 'TOTAL DUE:') ?></div>
    <div id="t2h_1" class="t s9_1"><?= $citation->getTotalPayment(true) ?></div>
    <div id="t2k_1" class="t s7_1"><?= Yii::t('app', 'Pay By / Contest By:') ?></div>
    <div id="t2l_1" class="t s8_1"><?= date('d M Y', $citation->expired_at) ?></div>

    <div id="t2m_1" class="t s3_1">If you choose to mail in your response, please select an option from</div>
    <div id="t2n_1" class="t s3_1">the below, and mail this stub back to the listed address:</div>

    <div id="t2o_1" class="t s3_1"><?= Yii::t('app', 'Payment enclosed') ?></div>
    <div id="t2p_1" class="t s3_1"><?= Yii::t('app', 'Request court date') ?></div>

    <!--footer-->

    <div id="tf_1" class="t s10_1"><?= Yii::t('app', 'VIEW THIS VIOLATION AND PAY ONLINE AT') ?></div>
    <div id="tg_1" class="t s11_1"><?= strtoupper($public_host) ?></div>
    <div id="th_1" class="t s10_1">OR CALL 1-844-901-STOP</div>

    <!-- End text definitions -->

    <!-- Begin page background -->
    <div id="pg1Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
    <div id="pg1">
        <object width="825" height="1100" data="<?= $svg ?>" type="image/svg+xml" id="pdf1"
                style="width:825px; height:1100px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object>
    </div>
    <!-- End page background -->

</div>

