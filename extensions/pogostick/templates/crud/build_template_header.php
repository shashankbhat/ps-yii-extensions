<?php
/*
 * This file is part of the psYiiExtensions package.
 * 
 * @copyright Copyright &copy; 2009 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * Include various options with generated code
 * 
 * @package 	psYiiExtensions.templates
 * @subpackage 	crud
 * 
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN: $Id: build_template_header.php 348 2009-12-24 08:46:38Z jerryablan@gmail.com $
 * @since 		v1.0.6
 *  
 * @filesource
 * 
 */

$_propList = null;

//	Get the defaults from the config file...
if ( ! $_sCopyright = Yii::app()->params['@copyright'] ) $_sCopyright = 'Copyright &copy; ' . date( 'Y' ) . ' You!';
if ( ! $_sAuthor = Yii::app()->params['@author'] ) $_sAuthor = 'Your Name <your@email.com>';
if ( ! $_sLink = Yii::app()->params['@link'] ) $_sLink = 'http://wwww.you.com';
if ( ! $_sPackage = Yii::app()->params['@package'] ) $_sPackage = Yii::app()->id;
if ( ! isset( $baseClass ) ) $baseClass = 'CPSModel';
if ( ! isset( $dbToUse ) ) $dbToUse = 'db';

//	Make property lines
if ( isset( $columns ) )
{
	foreach ( $columns as $_column )
		$_propList .= ' * @property ' . $_column->type . ' $' . $_column->name . PHP_EOL;
}

if ( isset( $relations ) && ! empty( $relations ) )
{
	foreach ( $relations as $_name => $_relation )
	{
		$_propList .= ' * @property ';

		$_types = array(
			'' => '',
			'' => '',
			'' => 'array',
			'' => 'array',
		);

		$_defaultType = 'mixed';

		if ( preg_match( "~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $_relation, $_matches ) )
		{
			switch ( $_matches[1] )
			{
				case 'HAS_ONE':
				case 'BELONGS_TO':
					$_propList .= $_matches[2] . ' $' . $_name . PHP_EOL;
					break;

				case 'HAS_MANY':
				case 'MANY_MANY':
					$_propList .= $_matches[2] . '[] $' . $_name . PHP_EOL;
					break;

				default:
					echo 'mixed $' . $_name . PHP_EOL;
					break;
			}
		}
	}
}

//	Output the header...
echo <<<HTML
<?php
/*
 * This file was generated by the psYiiExtensions scaffolding package.
 * 
 * @copyright {$_sCopyright}
 * @link {$_sLink}
 */
/**
 * {$className} file
 * 
 * @package 	{$_sPackage}
 * @subpackage 	
 * 
 * @author 		{$_sAuthor}
 * @version 	\$Id\$
 *  
 * @filesource
 *
 * {$_propList}
 */
HTML;
