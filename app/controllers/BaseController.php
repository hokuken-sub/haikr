<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    protected function setupTheme()
    {
        $theme_name = Config::get('theme.default');
        Theme::themeSet($theme_name);
    }

    protected function renderTheme()
    {
        return Theme::themeGet()->render();
    }
}