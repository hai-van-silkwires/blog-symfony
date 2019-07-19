<?php
namespace App\DTO\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDTOResolver implements ArgumentValueResolverInterface
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        $reflection = new \ReflectionClass($argument->getType());
        if ($reflection->implementsInterface(RequestDTOInterface::class)) {
            return true;
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        // creating new instance of custom request DTO
        $class = $argument->getType();
        $dto   = new $class($request);

        // return an array with error messages in case of invalid request data
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $validateErrors = array();
            foreach ($errors as $error) {
                $validateErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            $dto->setErrors($validateErrors);
        }

        yield $dto;
    }
}