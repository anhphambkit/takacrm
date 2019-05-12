<?php
/**
 * Created by PhpStorm.
 * User: anh.pham
 * Date: 4/29/2019
 * Time: 3:33 PM
 */

namespace Core\Setting\Contracts;


interface ReferenceConfig
{
    /* Reference gender */
    const REFERENCE_TYPE_GENDER                        = 'gender';
    const REFERENCE_MALE_GENDER                        = 'Male';
    const REFERENCE_FEMALE_GENDER                      = 'Female';

    /* Reference data customer */
    const REFERENCE_TYPE_CUSTOMER_DATA                 = 'reference_customer_data';
    const REFERENCE_USER_DATA                          = 'User';
    const REFERENCE_CUSTOMER_DATA                      = 'Customer';
}
