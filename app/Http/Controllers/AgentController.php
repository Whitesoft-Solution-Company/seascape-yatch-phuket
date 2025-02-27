<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::all();
        return view('admin.agent', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_name' => 'required|string|max:255',
            'agent_phone' => 'required|string|max:255',
            'agent_web' => 'nullable|url',
            'address' => 'nullable|string',
            'tex_number' => 'nullable|string',
            'type_user' => 'required|integer',
            'agent_status' => 'required|in:1,0',
        ]);

        // Create new agent record
        $agent = Agent::create([
            'agent_name' => $validated['agent_name'],
            'agent_phone' => $validated['agent_phone'],
            'agent_web' => $validated['agent_web'] ?? null,
            'address' => $validated['address'] ?? null,
            'tex_number' => $validated['tex_number'] ?? null,
            'type_user' => $validated['type_user'],
            'agent_status' => $validated['agent_status'],
            // Add any other fields as needed
        ]);

        // Redirect or return response
        return redirect()->route('admin.agents.index')->with('success', 'Agent created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
          // Validate input data
          $validated = $request->validate([
            'agent_name' => 'required|string|max:255',
            'agent_phone' => 'required|string|max:255',
            'agent_web' => 'nullable|url',
            'address' => 'nullable|string',
            'tex_number' => 'nullable|string',
            'type_user' => 'required|integer',
            'agent_status' => 'required|in:1,0',
        ]);
  
        // Find the agent by ID
        $agent = Agent::findOrFail($id);

        // Update agent data
        $agent->update([
            'agent_name' => $validated['agent_name'],
            'agent_phone' => $validated['agent_phone'],
            'agent_web' => $validated['agent_web'] ?? null,
            'address' => $validated['address'] ?? null,
            'tex_number' => $validated['tex_number'] ?? null,
            'type_user' => $validated['type_user'],
            'agent_status' => $validated['agent_status'],
            // Update any other fields as needed
        ]);

        // Redirect or return response
        return redirect()->route('admin.agents.index')->with('success', 'Agent updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the agent by ID
        $agent = Agent::findOrFail($id);

        // Delete the agent
        $agent->delete();

        // Redirect or return response
        return redirect()->route('admin.agents.index')->with('success', 'Agent deleted successfully!');
    }
}
