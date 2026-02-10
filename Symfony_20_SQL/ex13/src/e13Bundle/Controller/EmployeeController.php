<?php

namespace App\e13Bundle\Controller;

use App\e13Bundle\Entity\Employee;
use App\e13Bundle\Form\EmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class EmployeeController extends AbstractController {

    #[Route('/e13', name: 'employee_index')]
    public function index(EntityManagerInterface $em): Response {
        $employees = $em->getRepository(Employee::class)->findAll();
        return $this->render('e13/index.html.twig', ['employees' => $employees]);
    }

    // one road to create and edit
    #[Route('/employee/save/{id}', name: 'employee_save', defaults: ['id' => null])]
    public function save(Request $request, EntityManagerInterface $em, ?int $id): Response {
        
        if ($id) {
            $employee = $em->getRepository(Employee::class)->find($id);
            if (!$employee) {
                $this->addFlash('error', 'Employee not found.');
                return $this->redirectToRoute('employee_index');
            }
            $title = "Edit Employee";
        } else {
            $employee = new Employee();
            $title = "Create New Employee";
        }

        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($employee);
                $em->flush();
                $this->addFlash('success', 'Employee saved successfully!');
                return $this->redirectToRoute('employee_index');
            } catch (UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Email already exists!');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error: ' . $e->getMessage());
            }
        }

        return $this->render('e13/form.html.twig', [
            'form' => $form->createView(),
            'title' => $title
        ]);
    }

    #[Route('/employee/delete/{id}', name: 'employee_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response {
        $employee = $em->getRepository(Employee::class)->find($id);

        if ($employee) {
            try {
                $em->remove($employee);
                $em->flush();
                $this->addFlash('success', 'Employee deleted.');
            } catch (\Exception $e) {
                // au cas ou on supprime un manager qui a des subordonnés
                $this->addFlash('error', 'Cannot delete: This employee is a manager of others. Reassign them first.');
            }
        } else {
            $this->addFlash('error', 'Employee not found.');
        }

        return $this->redirectToRoute('employee_index');
    }
}