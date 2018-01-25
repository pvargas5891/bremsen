<?php
class Menu
{
	private $loader;
	private $page;
	private $module;
    private $type;

	public function __construct ($menu, $page, $module, $type = false, $level = false)
	{
		global $loader;

		$this->loader = $loader;
		$this->menu = $menu;
		$this->page = $page;
		$this->module = $module;
        $this->type = $type;
        $this->level = $level;

		if (isset($this->loader->build_php))
		{
            $output = '<?php Menu::make($config["menu"]["' . $this->loader->module . '"]';
            if ($this->level) $output .= '["' . $level . '"]';
            $output .= ', $page, $module';
            if ($this->type) $output .= ', "' . $this->type . '"';
            if ($this->level) $output .= ', "' . $this->level . '"';
            $output .= '); ?>';
			echo $output;
            return;
		}

		$this->makeMenu();
	}

	public static function make($menu, $page, $module, $type = false, $level = false)
	{
		return new static($menu, $page, $module, $type, $level);
	}

	public function makeMenu() 
	{
		global $skins;

        $isCollapse = $this->type == 'collapse';
        $isDiscover = $this->type == 'discover';

        foreach ($this->menu as $menu)
        {
            $menuId = 'menu-' . md5(time() . mt_rand(0, 1000000));
			$menuClass = array();
			$menuCollapseClass = array('collapse');
            $isSubmenu = !empty($menu['page']) && is_array($menu['page']);
			$menuLabel = true;
			$menuFile = false;

            if (isset($menu['file']) && $menu['file'] !== false)
			{
				$menuFile = $this->module . DS . 'menus' . DS . $menu['file'];
				$menuLabel = false;
			}

			if (isset($menu['class']))
				$menuClass[] = $menu['class'];

			if ($isCollapse && $isSubmenu)
				$menuClass[] = 'hasSubmenu';

			if ($isSubmenu && in_array_r($this->page, $menu['page']))
			{
				$menuClass[] = 'active';
				if ($isCollapse) $menuCollapseClass[] = 'in';
			}

			if (!$isSubmenu && isset($menu['page']) && $this->page == $menu['page'])
				$menuClass[] = 'active';
			?>
			<li class="<?php echo implode(" ", $menuClass); ?>">

				<?php
                if (!$menuFile)
                {
                    $href = '';
                    if ($isSubmenu) $href .='#' . $menuId;
                    if (!$isSubmenu)
                    {
                        if (isset($menu['href']))
                            $href = $menu['href'];

                        else
                        {
                            if (isset($menu['page']) && isset($menu['module']))
                                $href .= getURL(array('module' => $menu['module'], 'page' => $menu['page']));
                            elseif (isset($menu['page']))
                                $href .= getURL(array($menu['page']));
                        }
                    }

                    if (isset($menu['page']) || isset($menu['href'])): ?>
                    <a href="<?php echo $href; ?>"<?php if ($isSubmenu && $isCollapse): ?> data-toggle="<?php echo $this->type; ?>"<?php endif; ?><?php if ($isSubmenu && $isDiscover): ?> data-toggle="sidebar-discover"<?php endif; ?><?php if (isset($menu['link_class'])): ?> class="<?php echo $menu['link_class']; ?>"<?php endif; ?><?php if (isset($menu['link_target'])): ?> target="<?php echo $menu['link_target']; ?>"<?php endif; ?>>
                    <?php endif; ?>

                    <?php if (isset($menu['badge'])): ?>
                    <span class="badge pull-right<?php if (isset($menu['badge']['class'])): ?> <?php echo $menu['badge']['class']; ?><?php endif; ?>"><?php echo $menu['badge']['label']; ?></span>
                    <?php endif; ?>

                    <?php if (isset($menu['icon'])): ?>
                    <i class="<?php echo $menu['icon']; ?>"></i>
                    <?php endif; ?>

                    <?php if ($menuLabel): ?>
                    <span><?php echo $menu['label']; ?></span>
                    <?php endif; ?>

                <?php } ?>

				<?php if ($menuFile && @stream_resolve_include_path($menuFile)):
				ob_start();
				include $menuFile;
				$menuFileContent = ob_get_contents();
				ob_end_clean();
				echo $menuFileContent;
				endif; ?>

				<?php if (!$menuFile && (isset($menu['page']) || isset($menu['href']))): ?></a><?php endif; ?>

				<?php if ($isSubmenu): ?>
                    <?php if ($isDiscover): ?><div id="<?php echo $menuId; ?>" class="sidebar-discover-menu"><?php endif; ?>
                    <ul<?php if ($isCollapse): ?> class="<?php echo implode(" ", $menuCollapseClass); ?>" id="<?php echo $menuId; ?>"<?php endif; ?>>
                        <?php self::make($menu['page'], $this->page, $this->module, $this->type); ?>
                    </ul>
                    <?php if ($isDiscover): ?></div><?php endif; ?>
				<?php endif; ?>

			</li>
			<?php
		}
	}

}