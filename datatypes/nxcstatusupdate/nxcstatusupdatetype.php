<?php
/**
 * @package nxcSocialNetworks
 * @class   nxcSocialNetworksPublishType
 * @author  Joe Kepley <joe@blendinteractive.com>
 * @date    15 May 2013
 **/

class nxcStatusUpdateType extends eZDataType
{
    const DATA_TYPE_STRING = "nxcstatusupdate";

    function __construct()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezpI18n::tr( 'extension/nxc_social_networks', "Status Update", 'Datatype name' ),
            array( 'serialize_supported' => true ) );
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {

        /*
        if ( $http->hasPostVariable( $base . "_data_author_id_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $classAttribute = $contentObjectAttribute->contentClassAttribute();
            $idList = $http->postVariable( $base . "_data_author_id_" . $contentObjectAttribute->attribute( "id" ) );
            $nameList = $http->postVariable( $base . "_data_author_name_" . $contentObjectAttribute->attribute( "id" ) );
            $emailList = $http->postVariable( $base . "_data_author_email_" . $contentObjectAttribute->attribute( "id" ) );

            if ( $http->hasPostVariable( $base . "_data_author_remove_" . $contentObjectAttribute->attribute( "id" ) ) )
                $removeList = $http->postVariable( $base . "_data_author_remove_" . $contentObjectAttribute->attribute( "id" ) );
            else
                $removeList = array();

            if ( $contentObjectAttribute->validateIsRequired() )
            {
                if ( trim( $nameList[0] ) == "" )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                        'At least one author is required.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }
            if ( trim( $nameList[0] ) != "" )
            {
                for ( $i=0;$i<count( $idList );$i++ )
                {

                    $name =  $nameList[$i];
                    $email =  $emailList[$i];
                    if ( trim( $name )== "" )
                    {
                        $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                            'The author name must be provided.' ) );
                        return eZInputValidator::STATE_INVALID;

                    }
                    $isValidate =  eZMail::validate( $email );
                    if ( ! $isValidate )
                    {
                        $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                            'The email address is not valid.' ) );
                        return eZInputValidator::STATE_INVALID;
                    }
                }
            }
        }
        else
        {
            if ( $contentObjectAttribute->validateIsRequired() )
            {
                $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                    'At least one author is required.' ) );
                return eZInputValidator::STATE_INVALID;
            }
        }
        */
        return eZInputValidator::STATE_ACCEPTED;
    }

    /*!
     Store content
    */
    function storeObjectAttribute( $contentObjectAttribute )
    {
        $update = $contentObjectAttribute->content();
        $contentObjectAttribute->setAttribute( "data_text", $update->toXml() );
    }

    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        if ( $currentVersion != false )
        {
            $dataText = $originalContentObjectAttribute->attribute( "data_text" );
            $contentObjectAttribute->setAttribute( "data_text", $dataText );
        }
    }

    /*!
     Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {
        return nxcStatusUpdate::fromXml($contentObjectAttribute->attribute('data_text'));
    }


    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        $update = $contentObjectAttribute->content();

        if ( !$update )
            return false;

        return $update->shortUpdate . '\n' . $update->longUpdate;
    }

    function toString( $contentObjectAttribute )
    {
        /*
        $authorList = array();
        $content = $contentObjectAttribute->attribute( 'content' );
        foreach ( $content->attribute( 'author_list') as $author )
        {
            $authorList[] = eZStringUtils::implodeStr( array( $author['name'], $author['email'],$author['id'] ), '|' );
        }
        return eZStringUtils::implodeStr( $authorList, "&" );
        */
    }

    function fromString( $contentObjectAttribute, $string )
    {
        /*
        $authorList = eZStringUtils::explodeStr( $string, '&' );

        $author = new eZAuthor( );


        foreach ( $authorList as $authorStr )
        {
            $authorData = eZStringUtils::explodeStr( $authorStr, '|' );
            $author->addAuthor( $authorData[2], $authorData[0], $authorData[1] );

        }
        $contentObjectAttribute->setContent( $author );
        return $author;
        */
    }

    /*!
     Fetches the http post var integer input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_author_id_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $authorIDArray = $http->postVariable( $base . "_data_author_id_" . $contentObjectAttribute->attribute( "id" ) );
            $authorNameArray = $http->postVariable( $base . "_data_author_name_" . $contentObjectAttribute->attribute( "id" ) );
            $authorEmailArray = $http->postVariable( $base . "_data_author_email_" . $contentObjectAttribute->attribute( "id" ) );

            $update = new nxcStatusUpdate( '','', array() );

            /*
            $i = 0;
            foreach ( $authorIDArray as $id )
            {
                $author->addAuthor( $authorIDArray[$i], $authorNameArray[$i], $authorEmailArray[$i] );
                $i++;
            }
            */
            $contentObjectAttribute->setContent( $update );
        }
        return true;
    }

    function customObjectAttributeHTTPAction( $http, $action, $contentObjectAttribute, $parameters )
    {
    }

    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute('data_text') != '';
    }

    /*!
     Returns the string value.
    */
    function title( $contentObjectAttribute, $name = null )
    {
        $update = $contentObjectAttribute->content( );
        return $update->attribute('short_update');
    }

    function isIndexable()
    {
        return true;
    }

    function serializeContentObjectAttribute( $package, $objectAttribute )
    {
        $node = $this->createContentObjectAttributeDOMNode( $objectAttribute );

        $dom = new DOMDocument( '1.0', 'utf-8' );
        $success = $dom->loadXML( $objectAttribute->attribute( 'data_text' ) );

        $nodeDOM = $node->ownerDocument;
        $importedElement = $nodeDOM->importNode( $dom->documentElement, true );
        $node->appendChild( $importedElement );

        return $node;
    }

    function unserializeContentObjectAttribute( $package, $objectAttribute, $attributeNode )
    {
        $rootNode = $attributeNode->getElementsByTagName( 'nxcstatusupdate' )->item( 0 );
        $xmlString = $rootNode->ownerDocument->saveXML( $rootNode );
        $objectAttribute->setAttribute( 'data_text', $xmlString );
    }

    function supportsBatchInitializeObjectAttribute()
    {
        return true;
    }
}

eZDataType::register( nxcStatusUpdateType::DATA_TYPE_STRING, "nxcStatusUpdateType" );

?>
