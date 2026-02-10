<?php

namespace App\ex13Bundle\Controller;

use App\ex13Bundle\Entity\Employee;
use App\ex13Bundle\Form\EmployeeType;
use App\ex13Bundle\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController {

    #[Route('/ex13', name: 'employee_index', methods: ['GET'])]
    #[Route('/ex13/', name: 'employee_index_slash', methods: ['GET'])]
    public function index(EmployeeRepository $repo): Response {
        return $this->render('ex13/index.html.twig', [
            'employees' => $repo->findAll()
        ]);
    }

    #[Route('/employee/save/{id}', name: 'employee_save', defaults: ['id' => null], methods: ['GET', 'POST'])]
    public function save(Request $request, EmployeeRepository $repo, ?int $id): Response {
        $employee = $id ? $repo->find($id) : new Employee();
        
        if ($id && !$employee) {
            $this->addFlash('error', 'Employee not found.');
            return $this->redirectToRoute('employee_index');
        }

        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $repo->save($employee); // Utilisation du Repo (Règle 144)
                $this->addFlash('success', 'Employee saved successfully!');
                return $this->redirectToRoute('employee_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error: ' . $e->getMessage());
            }
        }

        return $this->render('ex13/form.html.twig', [
            'form' => $form->createView(),
            'title' => $id ? "Edit Employee" : "Create New Employee"
        ]);
    }

    #[Route('/employee/delete/{id}', name: 'employee_delete', methods: ['POST', 'GET'])]
    public function delete(EmployeeRepository $repo, int $id): Response {
        $employee = $repo->find($id);
        if ($employee) {
            try {
                $repo->remove($employee); // Utilisation du Repo (Règle 144)
                $this->addFlash('success', 'Employee deleted.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Cannot delete employee (possible relations exist).');
            }
        }
        return $this->redirectToRoute('employee_index');
    }
}