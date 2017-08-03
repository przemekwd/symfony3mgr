<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Translation\TranslatorInterface;

class MenuBuilder
{
    private $factory;
    private $tokenStorage;
    private $translator;

    public function __construct(FactoryInterface $factory, TokenStorage $tokenStorage, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
        $this->translator = $translator;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav navbar-nav navbar-left',
            ],
        ]);
        $menu->addChild($this->translator->trans('menu.home', [], 'AppBundle'), [
            'route' => 'homepage',
            'extras' => [
                'icon' => 'home',
            ],
        ]);
        $menu->addChild($this->translator->trans('menu.albums', [], 'AppBundle'), [
            'route' => 'album_index',
            'extras' => [
                'icon' => 'library_music',
            ],
        ]);
        $menu->addChild($this->translator->trans('menu.artists', [], 'AppBundle'), [
            'route' => 'artist_index',
            'extras' => [
                'icon' => 'face',
            ],
        ]);
        $menu->addChild($this->translator->trans('menu.distributors', [], 'AppBundle'), [
            'route' => 'distributor_index',
            'extras' => [
                'icon' => 'business',
            ],
        ])->setAttribute('class', 'bold');

        return $menu;
    }

    public function createUserMenu(array $options)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav navbar-nav navbar-right',
            ],
        ]);

        if ($token = $this->tokenStorage->getToken()->getRoles()) {
            $menu->addChild($this->tokenStorage->getToken()->getUsername(), [
                'uri' => '#',
                'attributes' => [
                    'class' => 'disabled',
                    'title' => $this->translator->trans('layout.logged_in_as', ['%username%' => $this->tokenStorage->getToken()->getUsername()], 'FOSUserBundle'),
                ],
                'extras' => [
                    'icon' => 'account_circle',
                    'user' => true,
                ],
            ]);
            $menu->addChild('', [
                'uri' => '/logout',
                'attributes' => [
                    'class' => 'usermenu-last',
                    'title' => $this->translator->trans('layout.logout', [], 'FOSUserBundle'),
                ],
                'extras' => [
                    'icon' => 'power_settings_new',
                ],
            ]);
        } else {
            $menu->addChild($this->translator->trans('security.login.submit', [], 'FOSUserBundle'), ['uri' => '/login']);
            $menu->addChild($this->translator->trans('registration.submit', [], 'FOSUserBundle'), [
                'uri' => '/register',
                'attributes' => [
                    'class' => 'usermenu-last'
                ],
            ]);
        }

        return $menu;
    }

}