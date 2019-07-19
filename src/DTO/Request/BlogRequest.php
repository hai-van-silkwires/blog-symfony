<?php

namespace App\DTO\Request;

use App\DTO\Request\RequestDTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class BlogRequest implements RequestDTOInterface
{
    /**
     * @Assert\NotBlank(
     *      message = "Title blog is required."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Title blog can't be longer than {{ limit }} characters."
     * )
     */
    public $title;

    /**
     * @Assert\NotBlank(
     *      message = "Content blog is required."
     * )
     */
    public $content;

    /**
     * @Assert\NotBlank(
     *      message = "Short description is required."
     * )
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "Short description can't be longer than 500 characters."
     * )
     */
    public $shortDescription;

    /**
     * @Assert\NotBlank(
     *      message = "Status is required."
     * )
     */
    public $status;

    /**
     * @Assert\NotBlank(
     *      message = "Category is required."
     * )
     */
    public $categoryId;

    /**
     * @Assert\NotBlank(
     *      message = "Feature image is required."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Feature image can't be longer than 255 characters."
     * )
     */
    public $featureImageName;

    public $featureImage;

    private $errors = [];

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function __construct(Request $request)
    {
        $this->title            = $request->get('title');
        $this->content          = $request->get('content');
        $this->shortDescription = $request->get('shortDescription');
        $this->status           = $request->get('status');
        $this->categoryId       = $request->get('categoryId');
        $this->featureImage     = !is_null($request->files->get('featureImage')) ? $request->files->get('featureImage') : null;
        $this->featureImageName = !is_null($this->featureImage) ? $this->featureImage->getClientOriginalName() : null;
    }
}