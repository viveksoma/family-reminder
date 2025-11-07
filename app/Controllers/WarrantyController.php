<?php namespace App\Controllers;

use App\Models\WarrantyModel;
use App\Models\FamilyModel;
use App\Models\FamilyMembersModel;

class WarrantyController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $familyId = session()->get('selected_family_id');
        $familyModel = new FamilyModel();
        $warrantyModel = new WarrantyModel();

        $data['familyId'] = $familyId;
        $data['familyName'] = $familyModel->find($familyId)['name'] ?? '';
        $data['warranties'] = $warrantyModel->where('family_id', $familyId)->findAll();

        return view('warranties/index', $data);
    }

    public function store()
    {
        $model = new WarrantyModel();

        $userId = session()->get('user_id');
        $familyId = session()->get('family_id');

        $file = $this->request->getFile('warranty_document');
        $filePath = null;

        if ($file && $file->isValid()) {
            // Clean up file name: remove spaces and replace with underscores
            $cleanName = preg_replace('/\s+/', '_', $file->getName());
            $file->move('uploads/warranties', $cleanName);
            $filePath = 'uploads/warranties/' . $cleanName;
        }

        // Parse dates
        $purchaseDate = $this->request->getPost('purchase_date');
        $expiryDate = $this->request->getPost('expiry_date');

        $data = [
            'user_id' => $userId,
            'family_id' => $familyId,
            'item_name' => $this->request->getPost('item_name'),
            'purchase_date' => $purchaseDate,
            'expiry_date' => $expiryDate,
            'warranty_document' => $filePath,
            'notes' => $this->request->getPost('notes'),
        ];

        $model->insert($data);

        return redirect()->to('/warranties')->with('message', 'Warranty added successfully!');
    }

    public function delete($id)
    {
        $model = new WarrantyModel();
        $model->delete($id);
        return redirect()->to('/warranties')->with('message', 'Warranty deleted successfully!');
    }
}
