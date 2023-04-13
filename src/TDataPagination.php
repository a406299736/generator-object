<?php
/**
 * User: Jin's
 * Date: 2022/8/18 11:32
 * Mail: jin.aiyo@hotmail.com
 * Desc: TODO
 */

namespace A406299736\GeneratorObject;

trait TDataPagination
{
    private $page;

    private $pageSize;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page ?: 1;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page): void
    {
        $this->page = (int)$page;
    }

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize ?: 10;
    }

    /**
     * @param mixed $pageSize
     */
    public function setPageSize($pageSize): void
    {
        $this->pageSize = (int)$pageSize;
    }
}
