<?php
/**
 * Created by PhpStorm.
 * User: yuda
 * Date: 23/01/19
 * Time: 1:20
 */
class Service extends CI_Model {

    function getService(){
        $query = $this->db->get('services');

        $datas = array();
        $counter = 0;
        foreach ($query->result() as $row) {
            $datas[$counter] = array (
                'type' => 'bubble',
                'hero' =>
                    array (
                        'type' => 'image',
                        'size' => 'full',
                        'aspectRatio' => '20:13',
                        'aspectMode' => 'cover',
                        'url' => 'https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_5_carousel.png',
                    ),
                'body' =>
                    array (
                        'type' => 'box',
                        'layout' => 'vertical',
                        'spacing' => 'sm',
                        'contents' =>
                            array (
                                0 =>
                                    array (
                                        'type' => 'text',
                                        'text' => $row->name,
                                        'wrap' => true,
                                        'weight' => 'bold',
                                        'size' => 'xl',
                                    ),
                                1 =>
                                    array (
                                        'type' => 'box',
                                        'layout' => 'baseline',
                                        'contents' =>
                                            array (
                                                0 =>
                                                    array (
                                                        'type' => 'text',
                                                        'text' => $row->address,
                                                        'wrap' => true,
                                                        'weight' => 'bold',
                                                        'size' => 'xl',
                                                        'flex' => 0,
                                                    ),
                                                1 =>
                                                    array (
                                                        'type' => 'text',
                                                        'text' => $row->phone,
                                                        'wrap' => true,
                                                        'weight' => 'bold',
                                                        'size' => 'sm',
                                                        'flex' => 0,
                                                    ),
                                            ),
                                    ),
                            ),
                    ),
                'footer' =>
                    array (
                        'type' => 'box',
                        'layout' => 'vertical',
                        'spacing' => 'sm',
                        'contents' =>
                            array (
                                0 =>
                                    array (
                                        'type' => 'button',
                                        'style' => 'primary',
                                        'action' =>
                                            array (
                                                'type' => 'uri',
                                                'label' => 'Add to Cart',
                                                'uri' => 'https://linecorp.com',
                                            ),
                                    ),
                                1 =>
                                    array (
                                        'type' => 'button',
                                        'action' =>
                                            array (
                                                'type' => 'uri',
                                                'label' => 'Add to wishlist',
                                                'uri' => 'https://linecorp.com',
                                            ),
                                    ),
                            ),
                    ),
            );

            $counter++;
        }

        return json_encode(
            array (
                'type' => 'carousel',
                'contents' =>
                    $datas
            )
        );
    }

}