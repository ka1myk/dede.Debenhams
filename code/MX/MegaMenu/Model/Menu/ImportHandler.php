<?php

namespace MX\MegaMenu\Model\Menu;

use MX\MegaMenu\Model\MenuFactory;
use MX\MegaMenu\Api\MenuRepositoryInterface;
use MX\MegaMenu\Api\ImportHandlerInterface;
use Magento\Framework\Exception\LocalizedException;

class ImportHandler implements ImportHandlerInterface
{
    const FILE_NO_ERROR = 0;

    /**
     * @var array
     */
    protected $menuKeys = [
        'menu_id', 'name', 'status', 'store_id', 'stores', 'menu_items', 'created_at', 'updated_at'
    ];

    /**
     * @var MenuFactory
     */
    private $menuFactory;

    /**
     * @var MenuRepositoryInterface
     */
    private $menuRepository;

    /**
     * @param MenuFactory $menuFactory
     */
    public function __construct(
        MenuFactory $menuFactory,
        MenuRepositoryInterface $menuRepository
    ) {
        $this->menuFactory = $menuFactory;
        $this->menuRepository = $menuRepository;
    }

    /**
     * Import from file
     *
     * @param mixed $file
     * @throws LocalizedException
     */
    public function importFromFile($file)
    {
        if (!$this->validateFile($file)) {
            throw new LocalizedException(__('Invalid file upload attempt.'));
        }

        $data = file_get_contents($file['tmp_name']);
        if (!$this->validateData($data)) {
            throw new LocalizedException(__('Invalid json file.'));
        }

        $this->import($data);
    }

    /**
     * Import data
     *
     * @param string $data
     */
    protected function import($data)
    {
        // Truncate data from database
        $this->menuRepository->deleteAll();

        // Fetch data
        $menuData = $this->decodeData($data);

        $newMenuId = 1;
        $newItemId = 1;
        $menuIdsRef = [];
        $menuItemIdsRef = [];

        // Assign references for the new menu item ids
        foreach ($menuData as $menuId => $menu) {
            $menuItems = [];
            foreach ($menu['menu_items'] as $itemId => $item) {
                // Gather old menu item id references
                $menuItemIdsRef[$itemId] = $newItemId;

                // Gather item data
                $menuItems[$newItemId] = $item;
                $menuItems[$newItemId]['menu_item_id'] = $newItemId;

                $newItemId++;
            }

            // Unset old indexes and set new indexes
            unset($menuData[$menuId]['menu_items']);
            $menuData[$menuId]['menu_items'] = $menuItems;

            // Gather old menu id references
            $menuIdsRef[$menuId] = $newMenuId;
            $newMenuId++;
        }

        // Assign references for the new menu ids
        foreach ($menuData as $menuId => $menu) {
            foreach ($menu['menu_items'] as $itemId => $item) {
                $parentId = $item['menu_item_parent_id'];
                if ($item['menu_item_parent_id'] > 0 && isset($menuItemIdsRef[$parentId])) {
                    $menuData[$menuId]['menu_items'][$itemId]['menu_item_parent_id'] = $menuItemIdsRef[$parentId];
                }

                // Save new menu_id for menu item
                if (isset($menuIdsRef[$menuId])) {
                    $menuData[$menuId]['menu_items'][$itemId]['menu_id'] = $menuIdsRef[$menuId];
                }
            }

            // Save new menu_id for menu
            if (isset($menuIdsRef[$menuId])) {
                $menuData[$menuId]['menu_id'] = $menuIdsRef[$menuId];
            }
        }

        // Save
        /** @var \MX\MegaMenu\Model\Menu $model */
        $model = $this->menuFactory->create();

        foreach ($menuData as $menu) {
            $model->setData($menu);
            $this->menuRepository->save($model);
        }
    }

    /**
     * Validate file data
     *
     * @param string $data
     * @return boolean
     */
    protected function validateData($data)
    {
        $menuData = $this->decodeData($data);
        if ($menuData) {
            $keysFound = 0;
            foreach ($menuData as $menu) {
                foreach ($menu as $key => $item) {
                    if (in_array($key, $this->menuKeys)) {
                        $keysFound++;
                    }
                }
            }

            return $keysFound == (count($menuData) * count($this->menuKeys));
        }

        return false;
    }

    /**
     * Validate file
     *
     * @param mixed $file
     * @return boolean
     */
    protected function validateFile($file)
    {
        return $file && isset($file['tmp_name']) && $file['error'] == self::FILE_NO_ERROR;
    }

    /**
     * @param string $data
     * @return mixed
     */
    protected function decodeData($data)
    {
        return json_decode($data, true);
    }
}