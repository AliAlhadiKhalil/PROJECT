using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using CVproject.Data;

namespace CVproject.Pages
{
    public class EditModel : PageModel
    {
        private readonly CVproject.Data.ProjectContext _context;

        public EditModel(CVproject.Data.ProjectContext context)
        {
            _context = context;
        }

        [BindProperty]
        public CV CV { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null || _context.cvs == null)
            {
                return NotFound();
            }

            var cv =  await _context.cvs.FirstOrDefaultAsync(m => m.Id == id);
            if (cv == null)
            {
                return NotFound();
            }
            CV = cv;
            return Page();
        }

        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see https://aka.ms/RazorPagesCRUD.
        public async Task<IActionResult> OnPostAsync()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            _context.Attach(CV).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!CVExists(CV.Id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return RedirectToPage("./Index");
        }

        private bool CVExists(int id)
        {
          return (_context.cvs?.Any(e => e.Id == id)).GetValueOrDefault();
        }
    }
}
