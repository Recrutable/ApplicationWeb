<?php

namespace OCUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OCUserBundle extends Bundle {
	/**
	 * On retourne le bundle parent
	 * {@inheritDoc}
	 * @see \Symfony\Component\HttpKernel\Bundle\Bundle::getParent()
	 */
	public function getParent() {
		return 'FOSUserBundle';
	}
}
