<?php
/**
 * Represents a social status update for use with the custom datatype
 * @package nxcSocialNetworks
 * @class   nxcSocialNetworksPublishType
 * @author  Joe Kepley <joe@blendinteractive.com>
 * @date    15 May 2013
 **/
class nxcStatusUpdate
{
    public $shortUpdate;
    public $longUpdate;
    public $accounts;

    public function __construct( $shortUpdate ='', $longUpdate='', $accounts = array() )
    {
        $this->shortUpdate = $shortUpdate;
        $this->longUpdate = $longUpdate;
    }

    public function toXml()
    {
        $doc = new DOMDocument( '1.0', 'utf-8' );

        $root = $doc->createElement( "nxcstatusupdate" );
        $doc->appendChild( $root );

        $short = $doc->createElement( "short" );
        $short->nodeValue = $this->shortUpdate;
        $root->appendChild( $short );

        $long = $doc->createElement( "long" );
        $long->nodeValue = $this->longUpdate;
        $root->appendChild( $long );

    }

    public static function fromXml( $xmlString )
    {
        return new nxcStatusUpdate('','', array());
    }
}