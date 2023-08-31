using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using CVproject.Data;

namespace CVproject.Pages
{
    public class DeleteModel : PageModel
    {
        private readonly CVproject.Data.ProjectContext _context;

        public DeleteModel(CVproject.Data.ProjectContext context)
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

            var cv = await _context.cvs.FirstOrDefaultAsync(m => m.Id == id);

            if (cv == null)
            {
                return NotFound();
            }
            else 
            {
                CV = cv;
            }
            return Page();
        }

        public async Task<IActionResult> OnPostAsync(int? id)
        {
            if (id == null || _context.cvs == null)
            {
                return NotFound();
            }
            var cv = await _context.cvs.FindAsync(id);

            if (cv != null)
            {
                CV = cv;
                _context.cvs.Remove(CV);
                await _context.SaveChangesAsync();
            }

            return RedirectToPage("./Index");
        }
    }
}
