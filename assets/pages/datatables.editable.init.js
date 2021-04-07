/**
* Theme: Adminto Admin Template
* Author: Coderthemes
* Component: Editable
* 
*/

(function( $ ) {

	'use strict';

	var EditableTable = {

		options: {			
			table: '#datatable-editable'			
		},

		initialize: function() {
			this
				.setVars()
				.build()
				.events();
		},

		setVars: function() {			
			this.$table = $( this.options.table );
			return this;
		},

		build: function() {
			this.datatable = this.$table.DataTable({
				aoColumns: [
					null,
					null,
					null,
					null,
                    null,
                    null,
                    null,
					{ "bSortable": false }
				]
			});

			window.dt = this.datatable;

			return this;
		},

		events: function() {
			

			return this;
		}

	};

	$(function() {
		EditableTable.initialize();
	});

}).apply( this, [ jQuery ]);