<?php
/**
 * @name		Mobile Menu CK
 * @package		mobile-menu-ck
 * @copyright	Copyright (C) 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
// No direct access to this file
defined('CK_LOADED') or die('Restricted access');
?>
<div class="ckleftpanelheader">
	<span class="ckleftpaneltitle"><?php echo CKText::_('CK_ROW_MANAGER'); ?></span>
	<span class="ckleftpanelheadericon ckclose ckhastip" title="<?php echo CKText::_('CK_SAVE_CLOSE'); ?>" onclick="ckCloseEdition();">×</span>
</div>
<div id="ckcolumnsoptions" class="ckinterface">
	<div id="ckgutteroptions" class="ckoption">
		<div class="menuckinfos"><?php echo CKText::_('CK_GUTTER') ?></div>
		<input class="ckguttervalue" type="text" onchange="ckUpdateGutter($ck('.ckrow.ckfocus'), this.value);" />
	</div>
	<div id="modulesnumberselect" class="ckoption">
		<div class="modulemanagerheader"><?php echo CKText::_('CK_NUMBER_OF_COLUMNS'); ?></div>
		<div class="ckoption-field ckbutton-group">
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(1);" style="width:25px;min-width:25px;"><?php echo CKText::_('1'); ?></label>
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(2);" style="width:25px;min-width:25px;"><?php echo CKText::_('2'); ?></label>
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(3);" style="width:25px;min-width:25px;"><?php echo CKText::_('3'); ?></label>
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(4);" style="width:25px;min-width:25px;"><?php echo CKText::_('4'); ?></label>
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(5);" style="width:25px;min-width:25px;"><?php echo CKText::_('5'); ?></label>
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(6);" style="width:25px;min-width:25px;"><?php echo CKText::_('6'); ?></label>
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(7);" style="width:25px;min-width:25px;"><?php echo CKText::_('7'); ?></label>
			<label class="ckbutton ckbutton-small" onclick="ckSelectNumberOfColumns(8);" style="width:25px;min-width:25px;"><?php echo CKText::_('8'); ?></label>
		</div>
		<input type="hidden" name="blocnumberselect" id="blocnumberselect" value="" />
		<div class="clr"></div>
	</div>
	<div id="ckcolumnsuggestions">

	</div>
</div>
<script language="javascript" type="text/javascript">
	function ckEditColumns(row, force, forcehide) {
		if (! force) force = false;
		if (row.find('.ckcolwidthedition').length && ! force || forcehide) {
			row.find('.ckcolwidthedition').remove();
			row.find('.ckcolwidthediting').removeClass('ckcolwidthediting');
		} else {
			var nbcols = row.find('.ckrowcontainer').length;
			$ck('#modulesnumberselect label').removeClass('active');
			$ck('#modulesnumberselect label').eq(nbcols - 1).addClass('active');
			var default_data_width = 100 / nbcols;
			row.find('.ckrowcontainer').each(function(i, column) {
				var column = $ck(column);
				column.addClass('ckcolwidthediting');
				var col_data_width = column.attr('data-width') ? column.attr('data-width') : default_data_width;
				if (! column.find('.ckcolwidthedition').length) column.append('<div class="ckcolwidthedition"><div class="ckcolwidthlocker ckhastip" title="<?php echo CKText::_('CK_LOCK_UNLOCK') ?>" onclick="ckToggleColWidthState(this);"></div><input id="' + row.attr('id') + '_w' + i + '" class="ckcolwidthselect inputbox" value="' + col_data_width + '" onchange="ckCalculateBlocsWidth(this);" type="text" /> %</div>')
			});
			ckInitTooltip();
		}
	}

	function ckToggleColWidthState(locker) {
		var input = $ck(locker).parent().find('input.ckcolwidthselect');
		var enableamount = $ck('.ckcolwidthselect:not(.disabled)', $ck(locker).parents('.ckrow')).length;
		var loackedamount = $ck('.ckcolwidthedition.locked', $ck(locker).parents('.ckrow')).length;

		if (loackedamount >= (enableamount - 1) && !input.hasClass('locked')) {
			alert('<?php echo CKText::_('CK_CAN_NOT_LOCK_ALL_WIDTH') ?>');
			return;
		}

		if (!input.hasClass('locked')) {
			input.addClass('locked');
			$ck(locker).addClass('locked');
			$ck(locker).parent().addClass('locked');
		} else {
			input.removeClass('locked');
			$ck(locker).removeClass('locked');
			$ck(locker).parent().removeClass('locked');
		}
	}

	function ckCalculateBlocsWidth(field) {
		var row = $ck($ck(field).parents('.ckrow')[0]);
		var enabledfields = $ck('.ckcolwidthedition:not(.disabled) .ckcolwidthselect:not(.disabled,.locked,#' + $ck(field).attr('id') + ')', row);
		var amount = enabledfields.length;
		var lockedvalue = 0;
		$ck('.ckcolwidthselect.locked', row).each(function(i, modulefield) {
			modulefield = $ck(modulefield);
			if (modulefield.attr('value') == '') {
				modulefield.removeClass('locked').next('input').attr('checked', false);
				ckCalculateBlocsWidth(field);
			}
			if (modulefield.attr('id') != $ck(field).attr('id')) {
				lockedvalue = parseFloat(modulefield.attr('value')) + parseFloat(lockedvalue);
			}
		});
		var mw = parseFloat($ck(field).attr('value'));
		var percent = (100 - mw - lockedvalue) / amount;

		enabledfields.each(function(i, modulefield) {
			if ($ck(modulefield).attr('id') != $ck(field).attr('id')
					&& !$ck(modulefield).hasClass('locked')) {
					
				$ck(modulefield).attr('value', parseFloat(percent));
			}
		});
		ckSetColumnsWidth(row);
	}

	function ckSetColumnsWidth(row) {
		var gutter = ckGetRowGutterValue(row);
		var nbcols = row.find('.ckrowcontainer').length;
		row.attr('numberofmodules', nbcols);
		row.find('.ckrowcontainer').each(function(i, col) {
			col = $ck(col);
			var w = col.find('.ckcolwidthselect').attr('value');
			if (col.find('.ckcolwidthselect').length) $ck(col).attr('data-width', col.find('.ckcolwidthselect').attr('value'));
			w = col.attr('data-width');
			// var realwidth =  w - (( (nbcols - 1) * parseFloat(gutter) ) / nbcols);
			ckSetColumnWidth(col, w, gutter, nbcols);
		});
	}

	function ckSetColumnWidth(col, w, gutter, nbcols) {
		var realwidth = 'calc(' + parseFloat(w) + ' / 100 * (100% - (' + (nbcols - 1) + ' * ' + gutter + ')))'; 
		col.attr('data-real-width', realwidth).attr('data-width', w).css('width', realwidth);
	}

	function ckGetRowGutterValue(row) {
		var gutter = row.attr('data-gutter') ? row.attr('data-gutter') : '0';
		gutter = ckTestUnit(gutter);
		row.attr('data-gutter', gutter);
		return gutter;
	}

	function ckUpdateGutter(row, gutter) {
		row.attr('data-gutter', ckTestUnit(gutter));
		ckSetColumnsWidth(row);
	}

	function ckSelectNumberOfColumns(number) {
		$ck('#blocnumberselect').attr('value', number);
		ckUpdateColumns();
		ckEditColumns($ck('.ckfocus'), true);
	}

	function ckUpdateColumns() {
		var row = $ck('.ckfocus');
		nbcols = $ck('#blocnumberselect').attr('value');
		row.attr('numberofmodules', nbcols);
		// check if we need to add a column
		nbexistingcols = $ck('> .inner > .ckrowcontainer', row).length;
		if (nbexistingcols < nbcols) {
			for (var i=0; i < (nbcols - nbexistingcols); i++) {
				ckCreateRowContainer(row);
			}
		}
		// check if we need to remove a column
		$ck('> .inner > .ckrowcontainer', row).each(function(i, bloc) {
			bloc = $ck(bloc);
			if (i >= nbcols) {
				if (bloc.find('.ckbloc').length) {
					bloc.prev().append(bloc.find('.ckbloc'));
					bloc.remove();
				} else {
					bloc.remove();
				}
			}
		});
		var moduleswidth = ckGetdefaultwidth(nbcols);
		$ck('> .inner > .ckrowcontainer', row).each(function(j, bloc) {
			bloc = $ck(bloc);
			var gutter = ckGetRowGutterValue(row);
			ckSetColumnWidth(bloc, moduleswidth[j], gutter, nbcols);
			// bloc.attr('data-width', moduleswidth[j]).css('width', moduleswidth[j] + '%');
			bloc.find('.ckcolwidthselect').val(moduleswidth[j]);
		});
	}

	function ckGetdefaultwidth(nbmodules) {
		var defaultwidths = new Array();
		defaultwidth = 100 / parseInt(nbmodules);
		for (i = 0; i < nbmodules; i++) {
			defaultwidths.push(defaultwidth);
		}
		return defaultwidths;
	}

	function ckBeforeCloseEditionPopup() {
		ckRemoveColumnEdition()
	}

	// init the options
	$ck('#ckedition .ckguttervalue').val(ckGetRowGutterValue($ck('.ckfocus')));
	ckEditColumns($ck('.ckfocus'), true);
	// CK_CAN_NOT_LOCK_ALL_WIDTH
	// CK_LOCK_UNLOCK
	// CK_GUTTER
	// CK_GUTTER_INFOS
</script>