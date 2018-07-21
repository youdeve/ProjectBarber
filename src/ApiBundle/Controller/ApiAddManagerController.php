<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\DepartmentType;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\View\View;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;

/**
 * Class ApiDepartmentController
 * @package ApiBundle\Controller
 */
class ApiAddManagerController extends FosRestController
{
  /** @var ContainerInterface */
  protected $container;

  /**
   * @Post("/Teams/new")
   * @Security("has_role('ROLE_ADD_ADMIN')")
   * @param Request $request
   * @return View
   */
  public function createPersonalTeamAction(Request $request)
  {
    try {

      $User = new User();
      $formDepartment = $this->createForm(DepartmentType::class, $department);
      $formDepartment->handleRequest($request);

      $department = $this->get('app.department_manager')->createNewDepartment($formDepartment, $department);
      if ($department instanceof Department) {
        return new View($department, Response::HTTP_CREATED);
      }

      return new View($department, Response::HTTP_UNPROCESSABLE_ENTITY
      );
    } catch (\Exception $e) {
      return new View([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

  /**
   * @Post("/departments/{id}/edit")
   * @param integer $id
   * @Security("has_role('ROLE_EDIT_DEPARTMENT')")
   * @param Request $request
   * @return View
   */
  public function editDepartmentAction($id, Request $request)
  {
    try {
      $department = $this->getDoctrine()->getRepository(Department::class)->find($id);
      $formDepartment = $this->createForm(DepartmentType::class, $department);
      $formDepartment->handleRequest($request);

      $department = $this->get('app.department_manager')->editDepartment($formDepartment, $department);
      if ($department instanceof Department) {
        return new View($department, Response::HTTP_OK);
      }

      return new View($department, Response::HTTP_UNPROCESSABLE_ENTITY);
    } catch (\Exception $e) {
      return new View([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }
}
