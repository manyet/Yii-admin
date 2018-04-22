var menu = {
	first: true,
	init: function() {
		var self = this, $body = $('body'), minSize = $.AdminLTE.options.screenSizes.sm - 1;
		this.$topContainer = $('#top-menu').on('click', '>li:not(.active)',function(){
			var $this = $(this);
			$this.addClass('active').siblings().removeClass('active');
			menu.$leftContainer.children().hide();
			menu.$leftContainer.children('[data-menu-parent=' + $this.data('menu-spm') + ']').slideDown(self.animationSpeed);
			self.$topContainer.parent().collapse('hide');
			if (!self.first && $(window).width() < minSize) {
				$body.addClass('sidebar-open');
			}
			self.first = false;
		});
		this.$leftContainer = $('#side-menu').on('click', 'li a', function(e){
			var $this = $(this);
			var checkElement = $this.next();

			if ((checkElement.is('.treeview-menu')) && (checkElement.is(':visible')) && (!$('body').hasClass('sidebar-collapse'))) {
			  checkElement.parent("li").removeClass('menu-open');;
			  checkElement.slideUp(self.animationSpeed, function () {
				//_this.layout.fix();
			  });

			  $.cookie('menu-' + $this.parent().data('menu-spm'), '0');
			} else if ((checkElement.is('.treeview-menu')) && (!checkElement.is(':visible'))) {
			  $this.parent("li").addClass('menu-open');

			  checkElement.slideDown(self.animationSpeed, function () {
				$.AdminLTE.layout.fix();
			  });

			  $.cookie('menu-' + $this.parent().data('menu-spm'), '1');
			}
			if (checkElement.is('.treeview-menu')) {
			  e.preventDefault();
			}
		}).on('click', '[data-open-page]', function (e) {
			e.preventDefault();
			if ($(window).width() < minSize) {
				$body.removeClass('sidebar-open');
			}
			$.page.redirect($(this).data('open-page'));
		});
		// 根据使用习惯展开菜单
		this.$leftContainer.find('[data-menu-spm]').each(function(){
			var $this = $(this);
			if ($.cookie('menu-' + $this.data('menu-spm')) != '0') self.expandSelf($this);
		});
	},
	animationSpeed: $.AdminLTE.options.animationSpeed,
	expandSelf: function($elem) {
		var $ul = $elem.children('ul');
		if ($ul.length) {
			$elem.addClass('menu-open');
			$ul.css('display', 'block');
		}
	},
	setActive: function($elem) {
		$elem.addClass('active').siblings('.active').removeClass('active').find('.active').removeClass('active');
		var $parent = $elem.parent(), isTreeMenu = $parent.is('.treeview-menu'), group;
		if (isTreeMenu) {
			$parent.show();
			this.setActive($parent.parent().addClass('menu-open'));
		} else if (group = $elem.data('menu-parent')) {
			var $con = this.$topContainer.children('[data-menu-spm=' + group + ']');
			!$con.hasClass('active') && $con.click();
		}
	},
	getActiveNode: function() {
		return this.$leftContainer.find('li:not(.treeview).active');
	}
};
menu.init();

require(["listeners"], function () {
});